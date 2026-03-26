<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    $instagramToken = config('instagram.token');
    $configuredWeeklyMenuPostUrl = config('instagram.weekly_menu_post_url');
    $instagramProfileUrl = config('instagram.profile_url');
    $instagramDebug = (bool) config('instagram.debug');
    $weeklyMenuCacheKey = 'instagram.weekly_menu_post_url.last_success';
    $cachedWeeklyMenuPostUrl = Cache::get($weeklyMenuCacheKey);
    $resolvedSource = null;
    $requestDiagnostics = [
        'profile_api_status' => null,
        'profile_api_error' => null,
        'profile_html_status' => null,
        'profile_html_error' => null,
        'graph_api_status' => null,
        'graph_api_error' => null,
    ];

    if (!empty($configuredWeeklyMenuPostUrl)) {
        $hasValidInstagramPostPath = preg_match(
            '~^https?://(www\.)?instagram\.com/(p|reel|tv)/[A-Za-z0-9_-]{5,}/?(\?.*)?$~i',
            $configuredWeeklyMenuPostUrl
        ) === 1;

        if (!$hasValidInstagramPostPath) {
            $configuredWeeklyMenuPostUrl = null;
        } else {
            $resolvedSource = 'configured_weekly_menu_url';
        }
    }

    $resolvedPinnedPostUrl = null;
    $latestPostUrl = null;

    $resolvePostUrlFromShortcode = static function (?string $shortcode, ?string $mediaType = null): ?string {
        if (empty($shortcode)) {
            return null;
        }

        $mediaPath = in_array($mediaType, ['reel', 'tv'], true) ? $mediaType : 'p';

        return "https://www.instagram.com/{$mediaPath}/{$shortcode}/";
    };

    $isValidInstagramPostUrl = static function (?string $url): bool {
        if (empty($url)) {
            return false;
        }

        return preg_match(
            '~^https?://(www\.)?instagram\.com/(p|reel|tv)/[A-Za-z0-9_-]{5,}/?(\?.*)?$~i',
            $url
        ) === 1;
    };

    $instagramGet = function (string $url, array $query = [], array $headers = []) use ($instagramDebug) {
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
    };

    if (empty($configuredWeeklyMenuPostUrl) && !empty($instagramProfileUrl)) {
        $profilePath = parse_url($instagramProfileUrl, PHP_URL_PATH) ?: '';
        $profilePath = trim($profilePath, '/');
        $username = explode('/', $profilePath)[0] ?? null;

        if (!empty($username)) {
            try {
                $profileResponse = $instagramGet(
                    'https://www.instagram.com/api/v1/users/web_profile_info/',
                    ['username' => $username],
                    [
                        'x-ig-app-id' => '936619743392459',
                        'user-agent' => 'Mozilla/5.0',
                        'referer' => 'https://www.instagram.com/',
                    ]
                );

                if ($profileResponse && $profileResponse->successful()) {
                    $requestDiagnostics['profile_api_status'] = $profileResponse->status();
                    $edges = data_get($profileResponse->json(), 'data.user.edge_owner_to_timeline_media.edges', []);

                    foreach ($edges as $edge) {
                        $pinnedForUsers = (array) data_get($edge, 'node.pinned_for_users', []);
                        $shortcode = data_get($edge, 'node.shortcode');

                        if (!empty($pinnedForUsers) && !empty($shortcode)) {
                            $resolvedPinnedPostUrl = $resolvePostUrlFromShortcode($shortcode);
                            $resolvedSource = 'profile_api_pinned';
                            break;
                        }
                    }

                    if (empty($resolvedPinnedPostUrl)) {
                        $latestShortcode = data_get($edges, '0.node.shortcode');
                        if (!empty($latestShortcode)) {
                            $latestPostUrl = $resolvePostUrlFromShortcode($latestShortcode);
                            $resolvedSource = 'profile_api_latest';
                        }
                    }

                    if ($instagramDebug) {
                        Log::info('Instagram profile API response parsed.', [
                            'edges_count' => is_array($edges) ? count($edges) : 0,
                            'resolved_source' => $resolvedSource,
                        ]);
                    }
                } elseif ($instagramDebug) {
                    $requestDiagnostics['profile_api_status'] = $profileResponse?->status();
                    Log::info('Instagram profile API did not return successful response.', [
                        'status' => $profileResponse?->status(),
                        'body_snippet' => $profileResponse ? mb_substr($profileResponse->body(), 0, 300) : null,
                    ]);
                } else {
                    $requestDiagnostics['profile_api_status'] = $profileResponse?->status();
                }
            } catch (\Throwable $exception) {
                $resolvedPinnedPostUrl = null;
                $latestPostUrl = null;
                $requestDiagnostics['profile_api_error'] = $exception->getMessage();

                if ($instagramDebug) {
                    Log::warning('Instagram profile API parsing failed.', [
                        'error' => $exception->getMessage(),
                    ]);
                }
            }

            if (empty($resolvedPinnedPostUrl) && empty($latestPostUrl)) {
                try {
                    $profileHtmlResponse = $instagramGet(
                        "https://www.instagram.com/{$username}/",
                        [],
                        [
                            'user-agent' => 'Mozilla/5.0',
                            'referer' => 'https://www.instagram.com/',
                        ]
                    );

                    if ($profileHtmlResponse && $profileHtmlResponse->successful()) {
                        $requestDiagnostics['profile_html_status'] = $profileHtmlResponse->status();
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

                        $latestPostUrl = $resolvePostUrlFromShortcode($matchedCode, $matchedType);
                        if (!empty($latestPostUrl)) {
                            $resolvedSource = 'profile_html_fallback';
                        }
                    } elseif ($instagramDebug) {
                        $requestDiagnostics['profile_html_status'] = $profileHtmlResponse?->status();
                        Log::info('Instagram profile HTML fallback did not return successful response.', [
                            'status' => $profileHtmlResponse?->status(),
                            'body_snippet' => $profileHtmlResponse ? mb_substr($profileHtmlResponse->body(), 0, 300) : null,
                        ]);
                    } else {
                        $requestDiagnostics['profile_html_status'] = $profileHtmlResponse?->status();
                    }
                } catch (\Throwable $exception) {
                    $latestPostUrl = null;
                    $requestDiagnostics['profile_html_error'] = $exception->getMessage();

                    if ($instagramDebug) {
                        Log::warning('Instagram profile HTML fallback parsing failed.', [
                            'error' => $exception->getMessage(),
                        ]);
                    }
                }
            }
        }
    }

    if (empty($configuredWeeklyMenuPostUrl) && empty($resolvedPinnedPostUrl) && empty($latestPostUrl) && !empty($instagramToken)) {
        try {
            $instagramResponse = $instagramGet(
                'https://graph.instagram.com/me/media',
                [
                    'fields' => 'permalink,media_type,timestamp',
                    'limit' => 1,
                    'access_token' => $instagramToken,
                ],
                [
                    'user-agent' => 'Mozilla/5.0',
                ]
            );

            if ($instagramResponse && $instagramResponse->successful()) {
                $requestDiagnostics['graph_api_status'] = $instagramResponse->status();
                $latestPostUrl = data_get($instagramResponse->json(), 'data.0.permalink');
                if (!empty($latestPostUrl)) {
                    $resolvedSource = 'graph_api_latest';
                }
            } elseif ($instagramDebug) {
                $requestDiagnostics['graph_api_status'] = $instagramResponse?->status();
                Log::info('Instagram Graph API did not return successful response.', [
                    'status' => $instagramResponse?->status(),
                    'body_snippet' => $instagramResponse ? mb_substr($instagramResponse->body(), 0, 300) : null,
                ]);
            } else {
                $requestDiagnostics['graph_api_status'] = $instagramResponse?->status();
            }
        } catch (\Throwable $exception) {
            $latestPostUrl = null;
            $requestDiagnostics['graph_api_error'] = $exception->getMessage();

            if ($instagramDebug) {
                Log::warning('Instagram Graph API request failed.', [
                    'error' => $exception->getMessage(),
                ]);
            }
        }
    }

    $finalWeeklyMenuPostUrl = $configuredWeeklyMenuPostUrl ?: $resolvedPinnedPostUrl ?: $latestPostUrl;

    if (empty($finalWeeklyMenuPostUrl) && $isValidInstagramPostUrl($cachedWeeklyMenuPostUrl)) {
        $finalWeeklyMenuPostUrl = $cachedWeeklyMenuPostUrl;
        $resolvedSource = 'cache_last_success';
    }

    if ($isValidInstagramPostUrl($finalWeeklyMenuPostUrl)) {
        Cache::put($weeklyMenuCacheKey, $finalWeeklyMenuPostUrl, now()->addDays(14));
    }

    if ($instagramDebug) {
        Log::info('Instagram weekly menu resolution debug.', [
            'profile_url' => $instagramProfileUrl,
            'has_token' => !empty($instagramToken),
            'configured_weekly_url' => $configuredWeeklyMenuPostUrl,
            'resolved_pinned_url' => $resolvedPinnedPostUrl,
            'resolved_latest_url' => $latestPostUrl,
            'resolved_source' => $resolvedSource,
            'final_url' => $finalWeeklyMenuPostUrl,
        ]);
    }

    if (empty($finalWeeklyMenuPostUrl)) {
        Log::warning('Instagram weekly menu post could not be resolved.', [
            'profile_url' => $instagramProfileUrl,
            'configured_weekly_url' => config('instagram.weekly_menu_post_url'),
            'has_token' => !empty($instagramToken),
            'resolved_source' => $resolvedSource,
            'cache_has_last_success' => $isValidInstagramPostUrl($cachedWeeklyMenuPostUrl),
            'profile_api_status' => $requestDiagnostics['profile_api_status'],
            'profile_api_error' => $requestDiagnostics['profile_api_error'],
            'profile_html_status' => $requestDiagnostics['profile_html_status'],
            'profile_html_error' => $requestDiagnostics['profile_html_error'],
            'graph_api_status' => $requestDiagnostics['graph_api_status'],
            'graph_api_error' => $requestDiagnostics['graph_api_error'],
        ]);
    }

    return view('home', [
        'weekly_menu_post_url' => $finalWeeklyMenuPostUrl,
        'instagram_profile_url' => $instagramProfileUrl,
    ]);
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/menu', [MenuController::class, 'index']);

Route::post('/add-to-cart/{id}', function ($id, Request $request) {
    $item = MenuItem::findOrFail($id);

    $cart = session()->get('cart', []);

    // If item already in cart, increase quantity
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'name' => $item->name,
            'price' => $item->price,
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', "{$item->name} added to cart!");
});

Route::post('/increment-cart/{id}', function ($id, Request $request) {
    $cart = session('cart', []);
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
        session(['cart' => $cart]);
    }
    return back();
});

Route::post('/decrement-cart/{id}', function ($id, Request $request) {
    $cart = session('cart', []);
    if (isset($cart[$id])) {
        if ($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity'] -= 1;
        } else {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
    }
    return back();
});

Route::post('/update-cart-quantity/{id}', function ($id, Request $request) {
    $cart = session('cart', []);
    $qty = max(1, (int) $request->input('quantity', 1));
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $qty;
        session(['cart' => $cart]);
    }
    return back();
});

Route::post('/remove-from-cart/{id}', function ($id) {
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back();
});
