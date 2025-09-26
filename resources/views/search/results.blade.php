@extends('layouts.main')

@section('title', 'Hasil Pencarian')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Hasil Pencarian untuk: "{{ $query }}"</h1>

        @if($products->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada produk yang cocok dengan pencarianmu. Coba kata kunci lain.
            </div>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-2 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset('products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-size text-secondary">Size {{ $product->size }}</p>
                                <p class="card-text text-danger">Rp {{ number_format($product->price) }}</p>
                                @auth
    <form action="{{ route('cart.add', $product) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Tambah ke Keranjang</button>
    </form>
@else
    <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Membeli</a>
@endauth
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