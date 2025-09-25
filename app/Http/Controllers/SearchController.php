<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil kata kunci dari input form
        $query = $request->input('query');

        // 2. Cari produk di database berdasarkan nama atau deskripsi
        $products = Product::query()
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12); // Gunakan paginate untuk hasil yang banyak

        // 3. Kirim hasil pencarian ke halaman view
        return view('search.results', compact('products', 'query'));
    }
}