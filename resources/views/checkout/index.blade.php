@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold">Checkout</h1>
        <div class="row mt-4">
            <div class="col-md-7">
                <h4>Ringkasan Pesanan</h4>
                <table class="table align-middle">
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                            <tr>
                                <td>
                                    <img src="{{ asset('products/' . $item->product->image) }}" width="50" class="me-2 rounded">
                                    {{ $item->product->name }} (x{{ $item->quantity }})
                                </td>
                                <td class="text-end">Rp {{ number_format($subtotal) }}</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td>Total Pembayaran</td>
                            <td class="text-end text-success">Rp {{ number_format($total) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-5">
                <h4>Detail Pengiriman & Pembayaran</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Penerima</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">Alamat Pengiriman</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                                <select class="form-select fw-semibold" id="payment_method" name="payment_method">
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="cod">Cash on Delivery (COD)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Buat Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection