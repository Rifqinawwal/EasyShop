<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('user.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'size' => 'required|string|max:10',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        Auth::user()->products()->create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'size' => $request->size,
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
        return view('user.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'size' => 'required|string|max:10',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if (File::exists(public_path('products/' . $product->image))) {
                File::delete(public_path('products/' . $product->image));
            }

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

        if (File::exists(public_path('products/' . $product->image))) {
            File::delete(public_path('products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('user.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}