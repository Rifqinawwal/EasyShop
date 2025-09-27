<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('user.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // === PERBAIKAN DI SINI ===
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:10', // Size bisa jadi opsional
            'category_id' => 'required|exists:categories,id', // Validasi 'category_id'
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        // === PERBAIKAN DI SINI ===
        Auth::user()->products()->create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'size' => $request->size,
            'category_id' => $request->category_id, // Simpan 'category_id'
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        // === PERBAIKAN DI SINI ===
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:10',
            'category_id' => 'required|exists:categories,id', // Validasi 'category_id'
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil semua data kecuali image
        $data = $request->except(['_token', '_method', 'image']);
        
        // Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && File::exists(public_path('products/' . $product->image))) {
                File::delete(public_path('products/' . $product->image));
            }
            // Upload gambar baru
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        if ($product->image && File::exists(public_path('products/' . $product->image))) {
            File::delete(public_path('products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}