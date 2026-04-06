<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramWeeklyMenuResolver
{
    public const CACHE_KEY = 'instagram.weekly_menu_post_url.last_success';

    public function resolveForHomepage(): array
    {
        $configuredUrl = $this->normalizeInstagramPostUrl(config('instagram.weekly_menu_post_url'));

        if ($configuredUrl) {
            return [
                'url' => $configuredUrl,
                'source' => 'configured_weekly_menu_url',
                'diagnostics' => [],
            ];
        }

        $cachedUrl = $this->normalizeInstagramPostUrl(Cache::get(self::CACHE_KEY));

        return [
            'url' => $cachedUrl,
            'source' => $cachedUrl ? 'cache_last_success' : null,
            'diagnostics' => [],
        ];
    }

    public function refreshCachedUrl(bool $allowCacheFallback = true): array
    {
        $instagramDebug = (bool) config('instagram.debug');
        $instagramToken = config('instagram.token');
        $instagramProfileUrl = config('instagram.profile_url');
        $configuredUrl = $this->normalizeInstagramPostUrl(config('instagram.weekly_menu_post_url'));
        $cachedUrl = $this->normalizeInstagramPostUrl(Cache::get(self::CACHE_KEY));
        $diagnostics = [
            'profile_api_status' => null,
            'profile_api_error' => null,
            'profile_html_status' => null,
            'profile_html_error' => null,
            'graph_api_status' => null,
            'graph_api_error' => null,
            'cache_has_last_success' => !empty($cachedUrl),
        ];

        if ($configuredUrl) {
            Cache::put(self::CACHE_KEY, $configuredUrl, now()->addDays(14));

            return [
                'url' => $configuredUrl,
                'source' => 'configured_weekly_menu_url',
                'diagnostics' => $diagnostics,
            ];
        }

        $resolvedPinnedPostUrl = null;
        $latestPostUrl = null;
        $resolvedSource = null;

        if (!empty($instagramProfileUrl)) {
            $profilePath = parse_url($instagramProfileUrl, PHP_URL_PATH) ?: '';
            $profilePath = trim($profilePath, '/');
            $username = explode('/', $profilePath)[0] ?? null;

            if (!empty($username)) {
                try {
                    $profileResponse = $this->instagramGet(
                        'https://www.instagram.com/api/v1/users/web_profile_info/',
                        ['username' => $username],
                        [
                            'x-ig-app-id' => '936619743392459',
                            'user-agent' => 'Mozilla/5.0',
                            'referer' => 'https://www.instagram.com/',
                        ],
                        $instagramDebug
                    );

                    if ($profileResponse && $profileResponse->successful()) {
                        $diagnostics['profile_api_status'] = $profileResponse->status();
                        $edges = data_get($profileResponse->json(), 'data.user.edge_owner_to_timeline_media.edges', []);

                        foreach ($edges as $edge) {
                            $pinnedForUsers = (array) data_get($edge, 'node.pinned_for_users', []);
                            $shortcode = data_get($edge, 'node.shortcode');

                            if (!empty($pinnedForUsers) && !empty($shortcode)) {
                                $resolvedPinnedPostUrl = $this->resolvePostUrlFromShortcode($shortcode);
                                $resolvedSource = 'profile_api_pinned';
                                break;
                            }
                        }

                        if (empty($resolvedPinnedPostUrl)) {
                            $latestShortcode = data_get($edges, '0.node.shortcode');
                            if (!empty($latestShortcode)) {
                                $latestPostUrl = $this->resolvePostUrlFromShortcode($latestShortcode);
                                $resolvedSource = 'profile_api_latest';
                            }
                        }

                        if ($instagramDebug) {
                            Log::info('Instagram profile API response parsed.', [
                                'edges_count' => is_array($edges) ? count($edges) : 0,
                                'resolved_source' => $resolvedSource,
                            ]);
                        }
                    } else {
                        $diagnostics['profile_api_status'] = $profileResponse?->status();

                        if ($instagramDebug) {
                            Log::info('Instagram profile API did not return successful response.', [
                                'status' => $profileResponse?->status(),
                                'body_snippet' => $profileResponse ? mb_substr($profileResponse->body(), 0, 300) : null,
                            ]);
                        }
                    }
                } catch (\Throwable $exception) {
                    $diagnostics['profile_api_error'] = $exception->getMessage();

                    if ($instagramDebug) {
                        Log::warning('Instagram profile API parsing failed.', [
                            'error' => $exception->getMessage(),
                        ]);
                    }
                }

                if (empty($resolvedPinnedPostUrl) && empty($latestPostUrl)) {
                    try {
                        $profileHtmlResponse = $this->instagramGet(
                            "https://www.instagram.com/{$username}/",
                            [],
                            [
                                'user-agent' => 'Mozilla/5.0',
                                'referer' => 'https://www.instagram.com/',
                            ],
                            $instagramDebug
                        );

                        if ($profileHtmlResponse && $profileHtmlResponse->successful()) {
                            $diagnostics['profile_html_status'] = $profileHtmlResponse->status();
                            $profileHtml = $profileHtmlResponse->body();
                            $matchedType = null;
                            $matchedCode = null;

                            if (preg_match('~/(p|reel|tv)/([A-Za-z0-9_-]{5,})/~', $profileHtml, $htmlMatch)) {
                                $matchedType = $htmlMatch[1];
                                $matchedCode = $htmlMatch[2];
                            } elseif (preg_match('~"shortcode":"([A-Za-z0-9_-]{5,})"~', $profileHtml, $jsonShortcodeMatch)) {
                                $matchedType = 'p';
                                $matchedCode = $jsonShortcodeMatch[1];
                            }

                            $latestPostUrl = $this->resolvePostUrlFromShortcode($matchedCode, $matchedType);
                            if (!empty($latestPostUrl)) {
                                $resolvedSource = 'profile_html_fallback';
                            }
                        } else {
                            $diagnostics['profile_html_status'] = $profileHtmlResponse?->status();

                            if ($instagramDebug) {
                                Log::info('Instagram profile HTML fallback did not return successful response.', [
                                    'status' => $profileHtmlResponse?->status(),
                                    'body_snippet' => $profileHtmlResponse ? mb_substr($profileHtmlResponse->body(), 0, 300) : null,
                                ]);
                            }
                        }
                    } catch (\Throwable $exception) {
                        $diagnostics['profile_html_error'] = $exception->getMessage();

                        if ($instagramDebug) {
                            Log::warning('Instagram profile HTML fallback parsing failed.', [
                                'error' => $exception->getMessage(),
                            ]);
                        }
                    }
                }
            }
        }

        if (empty($resolvedPinnedPostUrl) && empty($latestPostUrl) && !empty($instagramToken)) {
            try {
                $instagramResponse = $this->instagramGet(
                    'https://graph.instagram.com/me/media',
                    [
                        'fields' => 'permalink,media_type,timestamp',
                        'limit' => 1,
                        'access_token' => $instagramToken,
                    ],
                    [
                        'user-agent' => 'Mozilla/5.0',
                    ],
                    $instagramDebug
                );

                if ($instagramResponse && $instagramResponse->successful()) {
                    $diagnostics['graph_api_status'] = $instagramResponse->status();
                    $latestPostUrl = $this->normalizeInstagramPostUrl(data_get($instagramResponse->json(), 'data.0.permalink'));
                    if (!empty($latestPostUrl)) {
                        $resolvedSource = 'graph_api_latest';
                    }
                } else {
                    $diagnostics['graph_api_status'] = $instagramResponse?->status();

                    if ($instagramDebug) {
                        Log::info('Instagram Graph API did not return successful response.', [
                            'status' => $instagramResponse?->status(),
                            'body_snippet' => $instagramResponse ? mb_substr($instagramResponse->body(), 0, 300) : null,
                        ]);
                    }
                }
            } catch (\Throwable $exception) {
                $diagnostics['graph_api_error'] = $exception->getMessage();

                if ($instagramDebug) {
                    Log::warning('Instagram Graph API request failed.', [
                        'error' => $exception->getMessage(),
                    ]);
                }
            }
        }

        $finalUrl = $resolvedPinnedPostUrl ?: $latestPostUrl;

        if ($this->isValidInstagramPostUrl($finalUrl)) {
            Cache::put(self::CACHE_KEY, $finalUrl, now()->addDays(14));
        } elseif ($allowCacheFallback && $cachedUrl) {
            $finalUrl = $cachedUrl;
            $resolvedSource = 'cache_last_success';
        }

        if ($instagramDebug) {
            Log::info('Instagram weekly menu resolution debug.', [
                'profile_url' => $instagramProfileUrl,
                'has_token' => !empty($instagramToken),
                'configured_weekly_url' => $configuredUrl,
                'resolved_pinned_url' => $resolvedPinnedPostUrl,
                'resolved_latest_url' => $latestPostUrl,
                'resolved_source' => $resolvedSource,
                'final_url' => $finalUrl,
                ...$diagnostics,
            ]);
        }

        if (empty($finalUrl)) {
            Log::warning('Instagram weekly menu post could not be resolved.', [
                'profile_url' => $instagramProfileUrl,
                'configured_weekly_url' => $configuredUrl,
                'has_token' => !empty($instagramToken),
                'resolved_source' => $resolvedSource,
                ...$diagnostics,
            ]);
        }

        return [
            'url' => $finalUrl,
            'source' => $resolvedSource,
            'diagnostics' => $diagnostics,
        ];
    }

    public function normalizeInstagramPostUrl(?string $url): ?string
    {
        $url = is_string($url) ? trim($url) : null;

        if (empty($url)) {
            return null;
        }

        if (preg_match('~instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]{5,})/?~i', $url, $matches)) {
            return sprintf('https://www.instagram.com/%s/%s/', strtolower($matches[1]), $matches[2]);
        }

        return null;
    }

    private function isValidInstagramPostUrl(?string $url): bool
    {
        return !empty($this->normalizeInstagramPostUrl($url));
    }

    private function resolvePostUrlFromShortcode(?string $shortcode, ?string $mediaType = null): ?string
    {
        if (empty($shortcode)) {
            return null;
        }

        $mediaPath = in_array($mediaType, ['reel', 'tv'], true) ? $mediaType : 'p';

        return "https://www.instagram.com/{$mediaPath}/{$shortcode}/";
    }

    private function instagramGet(string $url, array $query, array $headers, bool $instagramDebug)
    {
        try {
            $primaryResponse = Http::timeout(6)
                ->retry(1, 250)
                ->withHeaders($headers)
                ->get($url, $query);

            if ($primaryResponse->successful()) {
                return $primaryResponse;
            }

            if ($instagramDebug) {
                Log::info('Instagram request primary attempt not successful.', [
                    'url' => $url,
                    'status' => $primaryResponse->status(),
                    'query_keys' => array_keys($query),
                ]);
            }
        } catch (\Throwable $exception) {
            if ($instagramDebug) {
                Log::warning('Instagram request primary attempt threw exception.', [
                    'url' => $url,
                    'query_keys' => array_keys($query),
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        try {
            $fallbackResponse = Http::timeout(6)
                ->retry(1, 250)
                ->withOptions(['verify' => false])
                ->withHeaders($headers)
                ->get($url, $query);

            if ($instagramDebug && !$fallbackResponse->successful()) {
                Log::info('Instagram request fallback attempt not successful.', [
                    'url' => $url,
                    'status' => $fallbackResponse->status(),
                    'query_keys' => array_keys($query),
                ]);
            }

            return $fallbackResponse;
        } catch (\Throwable $exception) {
            if ($instagramDebug) {
                Log::warning('Instagram request fallback attempt threw exception.', [
                    'url' => $url,
                    'query_keys' => array_keys($query),
                    'error' => $exception->getMessage(),
                ]);
            }

            return null;
        }
    }
}
