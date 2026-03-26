<?php

use App\Support\InstagramWeeklyMenuResolver;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Models\MenuItem;
use Illuminate\Http\Request;

Route::get('/', function () {
    $instagramProfileUrl = config('instagram.profile_url');
    $instagramResolution = app(InstagramWeeklyMenuResolver::class)->resolveForHomepage();

    return view('home', [
        'weekly_menu_post_url' => $instagramResolution['url'],
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
