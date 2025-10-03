@extends('layouts.main')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('products/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold">{{ $product->name }}</h1>
                <h3 class="text-success">Rp {{ number_format($product->price) }}</h3>
                <p class="mt-3"><strong>Ukuran:</strong> {{ $product->size }}</p>
                <p><strong>Stok:</strong> {{ $product->stock }}</p>

                <hr>

                <p>{{ $product->description }}</p>

                <div class="d-flex justify-content-start align-items-center mt-4">
                    @auth
                        <a href="#" class="btn btn-primary btn-lg me-2">Beli Sekarang</a>

                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-lg">
                                <span class="material-symbols-outlined">
                                    add_shopping_cart
                                </span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">Login untuk Membeli</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection