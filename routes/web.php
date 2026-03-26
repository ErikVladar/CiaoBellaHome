<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    $instagramToken = config('instagram.instagram.token');
    $configuredWeeklyMenuPostUrl = config('instagram.instagram.weekly_menu_post_url');
    $instagramProfileUrl = config('instagram.instagram.profile_url');

    $resolvedPinnedPostUrl = null;
    $latestPostUrl = null;

    if (empty($configuredWeeklyMenuPostUrl) && !empty($instagramProfileUrl)) {
        $profilePath = parse_url($instagramProfileUrl, PHP_URL_PATH) ?: '';
        $profilePath = trim($profilePath, '/');
        $username = explode('/', $profilePath)[0] ?? null;

        if (!empty($username)) {
            try {
                $profileResponse = Http::timeout(5)
                    ->retry(1, 200)
                    ->withHeaders([
                        'x-ig-app-id' => '936619743392459',
                        'user-agent' => 'Mozilla/5.0',
                    ])
                    ->get('https://www.instagram.com/api/v1/users/web_profile_info/', [
                        'username' => $username,
                    ]);

                if ($profileResponse->successful()) {
                    $edges = data_get($profileResponse->json(), 'data.user.edge_owner_to_timeline_media.edges', []);

                    foreach ($edges as $edge) {
                        $pinnedForUsers = (array) data_get($edge, 'node.pinned_for_users', []);
                        $shortcode = data_get($edge, 'node.shortcode');

                        if (!empty($pinnedForUsers) && !empty($shortcode)) {
                            $resolvedPinnedPostUrl = "https://www.instagram.com/p/{$shortcode}/";
                            break;
                        }
                    }

                    if (empty($resolvedPinnedPostUrl)) {
                        $latestShortcode = data_get($edges, '0.node.shortcode');
                        if (!empty($latestShortcode)) {
                            $latestPostUrl = "https://www.instagram.com/p/{$latestShortcode}/";
                        }
                    }
                }
            } catch (\Throwable $exception) {
                $resolvedPinnedPostUrl = null;
                $latestPostUrl = null;
            }
        }
    }

    if (empty($configuredWeeklyMenuPostUrl) && empty($resolvedPinnedPostUrl) && empty($latestPostUrl) && !empty($instagramToken)) {
        try {
            $instagramResponse = Http::timeout(5)
                ->retry(1, 200)
                ->get('https://graph.instagram.com/me/media', [
                    'fields' => 'permalink,media_type,timestamp',
                    'limit' => 1,
                    'access_token' => $instagramToken,
                ]);

            if ($instagramResponse->successful()) {
                $latestPostUrl = data_get($instagramResponse->json(), 'data.0.permalink');
            }
        } catch (\Throwable $exception) {
            $latestPostUrl = null;
        }
    }

    return view('home', [
        'weekly_menu_post_url' => $configuredWeeklyMenuPostUrl ?: $resolvedPinnedPostUrl ?: $latestPostUrl,
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
