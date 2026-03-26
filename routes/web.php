<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    $instagramToken = config('instagram.token');
    $configuredWeeklyMenuPostUrl = config('instagram.weekly_menu_post_url');
    $instagramProfileUrl = config('instagram.profile_url');
    $instagramDebug = (bool) config('instagram.debug');

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
    $resolvedSource = null;

    $resolvePostUrlFromShortcode = static function (?string $shortcode, ?string $mediaType = null): ?string {
        if (empty($shortcode)) {
            return null;
        }

        $mediaPath = in_array($mediaType, ['reel', 'tv'], true) ? $mediaType : 'p';

        return "https://www.instagram.com/{$mediaPath}/{$shortcode}/";
    };

    $instagramGet = static function (string $url, array $query = [], array $headers = []) {
        try {
            $primaryResponse = Http::timeout(6)
                ->retry(1, 250)
                ->withHeaders($headers)
                ->get($url, $query);

            if ($primaryResponse->successful()) {
                return $primaryResponse;
            }
        } catch (\Throwable $exception) {
        }

        try {
            return Http::timeout(6)
                ->retry(1, 250)
                ->withOptions(['verify' => false])
                ->withHeaders($headers)
                ->get($url, $query);
        } catch (\Throwable $exception) {
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
                }
            } catch (\Throwable $exception) {
                $resolvedPinnedPostUrl = null;
                $latestPostUrl = null;
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
                        $profileHtml = $profileHtmlResponse->body();
                        $matchedType = null;
                        $matchedCode = null;

                        if (preg_match('~/(p|reel|tv)/([A-Za-z0-9_-]{5,})/~', $profileHtml, $htmlMatch)) {
                            $matchedType = $htmlMatch[1];
                            $matchedCode = $htmlMatch[2];
                        }

                        $latestPostUrl = $resolvePostUrlFromShortcode($matchedCode, $matchedType);
                        if (!empty($latestPostUrl)) {
                            $resolvedSource = 'profile_html_fallback';
                        }
                    }
                } catch (\Throwable $exception) {
                    $latestPostUrl = null;
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
                $latestPostUrl = data_get($instagramResponse->json(), 'data.0.permalink');
                if (!empty($latestPostUrl)) {
                    $resolvedSource = 'graph_api_latest';
                }
            }
        } catch (\Throwable $exception) {
            $latestPostUrl = null;
        }
    }

    $finalWeeklyMenuPostUrl = $configuredWeeklyMenuPostUrl ?: $resolvedPinnedPostUrl ?: $latestPostUrl;

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
