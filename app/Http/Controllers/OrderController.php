<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
{
    // Keamanan: pastikan user hanya bisa melihat notanya sendiri
    if (Auth::id() !== $order->user_id) {
        abort(403);
    }
    return view('orders.show', compact('order'));
}
}
