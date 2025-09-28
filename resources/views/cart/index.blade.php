@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container py-5">
        <h1>Keranjang Belanja</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($cartItems->isNotEmpty())
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $item)
                        @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('products/' . $item->product->image) }}" width="60" class="me-3 rounded">
                                    <div>
                                        <div class="fw-bold">{{ $item->product->name }}</div>
                                        <div class="text-muted small">Size: {{ $item->product->size }}</div> </div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($item->product->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($subtotal) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <h3 class="text-success">Total: Rp {{ number_format($total) }}</h3>
                <a href="#" class="btn btn-primary">Lanjutkan ke Checkout</a>
            </div>
        @else
            <div class="alert alert-info text-center">
                Keranjang belanjamu masih kosong.
            </div>
        @endif
    </div>
@endsection