<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        // Jika keranjang kosong, jangan biarkan masuk ke checkout
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('info', 'Keranjang Anda kosong.');
        }

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
{
    // 1. Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'payment_method' => 'required|string',
    ]);

    $cartItems = Auth::user()->cartItems()->with('product')->get();
    if ($cartItems->isEmpty()) {
        return redirect()->route('home')->with('info', 'Keranjang Anda kosong.');
    }

    // Gunakan DB Transaction untuk keamanan data
    $order = DB::transaction(function () use ($request, $cartItems) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // 2. Buat pesanan baru
        $order = Auth::user()->orders()->create([
            'order_number' => 'INV-' . strtoupper(Str::random(10)),
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->address,
            'status' => 'pending',
        ]);

        // 3. Pindahkan item dari keranjang ke item pesanan
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // 4. Kurangi stok produk
            $item->product->decrement('stock', $item->quantity);
        }

        // 5. Kosongkan keranjang
        Auth::user()->cartItems()->delete();

        return $order;
    });

    // 6. Redirect ke halaman nota/sukses
    return redirect()->route('order.success', $order)->with('success', 'Pesanan Anda berhasil dibuat!');
}
}