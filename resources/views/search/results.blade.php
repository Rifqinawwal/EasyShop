@extends('layouts.main')

@section('title', 'Hasil Pencarian')

@section('content')

{{-- Style ini bisa kamu pindahkan ke file CSS utamamu jika mau --}}
<style>
    .btn-cart-icon {
        padding: 0.2rem 0.4rem;
    }
    .btn-cart-icon .material-symbols-outlined {
        font-size: 1rem;
        vertical-align: middle;
    }
</style>

    <div class="container py-5">
        <h1 class="mb-4">Hasil Pencarian untuk: "{{ $query }}"</h1>

        @if($products->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada produk yang cocok dengan pencarianmu. Coba kata kunci lain.
            </div>
        @else
            <div class="row">
                {{-- PERBAIKAN: Gunakan variabel $product (tunggal) di dalam loop --}}
                @foreach($products as $product)
                    <div class="col-md-2 mb-3"> {{-- Saya ubah ke col-md-3 agar card lebih lega --}}
                        <div class="card h-100">
                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ asset('products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product) }}" class="text-dark fw-bold text-decoration-none">{{ $product->name }}</a>
                                </h5>
                                @if($product->size)
                                    <p class="card-text text-muted small">Size: {{ $product->size }}</p>
                                @endif
                                <p class="card-text text-success fw-bold">Rp {{ number_format($product->price) }}</p>
                                
                                {{-- PERBAIKAN: Bungkus kedua form dengan div.d-flex --}}
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                                    @auth
                                        {{-- PERBAIKAN: Arahkan ke route 'cart.buy_now' --}}
                                        <form action="{{ route('cart.buy_now', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm me-2">Beli Sekarang</button>
                                        </form>
                                        
                                        {{-- PERBAIKAN: Gunakan variabel $product (tunggal) --}}
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm btn-cart-icon">
                                                <span class="material-symbols-outlined">
                                                    add_shopping_cart
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100">Login untuk Membeli</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection