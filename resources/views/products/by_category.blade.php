@extends('layouts.main')

@section('title', 'Kategori: ' . $category->name)

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Produk dalam Kategori: "{{ $category->name }}"</h1>

        @if($products->isEmpty())
            <div class="alert alert-info text-center">
                Belum ada produk dalam kategori ini.
            </div>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-6 col-md-3 mb-4">
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
                    
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                        @auth
                            <a href="#" class="btn btn-primary">Beli Sekarang</a>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <span class="material-symbols-outlined">
                                        add_shopping_cart
                                    </span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Membeli</a>
                        @endauth
                    </div>
                </div>
            </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection