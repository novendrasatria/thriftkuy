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
        $categories = Category::all(); 
        $products = Product::with('galleries')->paginate(32); //paginate digunakan untuk paging, akan mengambil data produk sebanyak 32 per halaman

        return view('pages.category',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
    //detail digunakan untuk saat menu kategori diplilih salah satu,maka hanya menampilkan produk berdasarkan kategori yang dipilih tersebut
    public function detail(Request $request, $slug)
    {
        $categories = Category::all();  //all,mengambil semua data kategori
        $category = Category::where('slug', $slug)->firstOrFail(); 
        $products = Product::where('categories_id', $category->id)->paginate($request->input('limit', 12)); 
        return view('pages.category',[
            'categories' => $categories,
            'category' => $category,
            'products' => $products
        ]);
    }
}
