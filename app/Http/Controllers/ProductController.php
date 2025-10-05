<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    // TAMBAHKAN METHOD BARU INI
    public function show(Product $product)
    {
        // Laravel akan otomatis mencari produk berdasarkan ID di URL (Route Model Binding)
        return view('products.show', compact('product'));
    }

        // METHOD BARU UNTUK MENAMPILKAN PRODUK PER KATEGORI
    public function byCategory(Category $category)
    {
        // Ambil produk yang berelasi dengan kategori ini, lalu paginasi
        $products = $category->products()->latest()->paginate(12);

        // Kirim data produk dan data kategori ke view
        return view('products.by_category', compact('products', 'category'));
    }
}