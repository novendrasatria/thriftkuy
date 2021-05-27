<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Category;
use App\ProductGallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Auth;

class DashboardProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries','category']) //variabel products akan melakukan relasi dengan galleries dan category
        ->where('users_id',Auth::user()->id) //mengambil data besarkan user_id yang sedang login (Auth)
        ->get();
        return view('pages.dashboard-products',[
            'products' => $products
        ]); //array memanggil hasil dari variabel products
    }
    public function details(Request $request, $id)
    {
        $product = Product::with(['galleries','user','category'])->findOrFail($id); //variabel product akan memangil data produk dengan melakukan relasi dengan 'galleries','user','category'
        $categories = Category::all(); //variabel categories tersebut memanggil semua data dari Category

        return view('pages.dashboard-products-details',[
            'product' => $product,
            'categories' => $categories
        ]); //memanggil product dan categories untuk ditampilkan pada dashboard-products-details
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all(); //variabel data tersebut memanggil semua data yang masuk ke bagian gallery request

        $data['photos'] = $request->file('photos')->store('assets/product', 'public'); //akan menyimpan foto produk

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-details', $request->products_id); //foto akan ditampilkan pada dashboard-product-details dengan request berdasarkan products_id yang diedit
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findorFail($id); //mencari foto jika ada sesuai id
        $item->delete(); //jika ada maka dihapus dengan menggunakan fungsi delete

        return redirect()->route('dashboard-product-details', $item->products_id);
    }

    public function create()
    {
        $categories = Category::all(); //variabel categories memanggil data kategoru
        return view('pages.dashboard-products-create',[
            'categories' => $categories
        ]); //array memanggil hasil dari variabel categories
    } 
    public function store(ProductRequest $request)
    {
        $data = $request->all(); //variabel data tersebut memanggil semua data yang masuk ke bagian product request

        $data['slug'] = Str::slug($request->name); //digunakan untuk menyimpan data produk dalam bentuk slug, slug sendiri akan digunakan untuk keperluan link, misal nama produk adalah vans oldschool, maka slug menjadi vans-oldschool
        $product = Product::create($data); //menyimpan data

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product', 'public')
        ]; //berisi data id produk dan foto yang akan disimpan
        ProductGallery::create($gallery); //memanggil ProductGallery

        return redirect()->route('dashboard-product');
    }
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all(); //memanggil semua data produk yang masuk ke bagian product request
        $item = Product::findOrFail($id); //mencari produk jika ada sesuai id
        $data['slug'] = Str::slug($request->name); //slug melakukan request nama produk
        $item->update($data); //jika produk ada maka dilakukan update data dengan menggunakan fungsi update
        return redirect()->route('dashboard-product');
    }
}