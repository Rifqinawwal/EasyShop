<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {
        $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat item keranjang baru
            Auth::user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $cartItem)
{
    // Otorisasi
    if ($cartItem->user_id !== Auth::id()) {
        abort(403);
    }

    $action = $request->input('action');

    if ($action == 'increase') {
        $cartItem->increment('quantity');
    } elseif ($action == 'decrease') {
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            // Jika kuantitas 1 dan dikurangi, hapus item
            $cartItem->delete();
        }
    }

    return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
}

    public function remove(CartItem $cartItem)
    {
        // Otorisasi: pastikan user hanya bisa menghapus item miliknya
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // app/Http/Controllers/CartController.php
public function buyNow(Request $request, Product $product)
{
    $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();

    if ($cartItem) {
        $cartItem->increment('quantity');
    } else {
        Auth::user()->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    // Langsung arahkan ke halaman checkout
    return redirect()->route('checkout.index');
}
}