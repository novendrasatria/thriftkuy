<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::take(6)->get(); //ambil display 6 kategori
        $products = Product::with('galleries')->take(8)->get(); //ambil display 8 produk
        return view('pages.home',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
