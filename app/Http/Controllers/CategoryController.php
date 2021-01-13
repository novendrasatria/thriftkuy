<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all(); //ambil display 6 kategori
        $products = Product::with('galleries')->paginate(32); 
        return view('pages.category',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('categories_id', $category->id)->paginate($request->input('limit', 12));

        return view('pages.category',[
            'categories' => $categories,
            'category' => $category,
            'products' => $products
        ]);
    }
}
