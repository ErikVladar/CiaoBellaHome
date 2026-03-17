<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuController extends Controller
{
    // public function index()
    // {
    //     $menuItems = MenuItem::all();
    //     return view('menu', compact('menuItems'));
    // }
    public function index()
    {
        $menuItems = MenuItem::all();
        $types = MenuItem::select('type')->distinct()->pluck('type');
        $cart = session('cart', []);
        return view('menu', compact('menuItems', 'types', 'cart'));
    }
}
