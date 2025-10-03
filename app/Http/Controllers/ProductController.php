<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
}