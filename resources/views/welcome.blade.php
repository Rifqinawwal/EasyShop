{{-- Menggunakan file layout utama --}}
@extends('layouts.main')

{{-- Mengisi judul halaman --}}
@section('title', 'Selamat Datang')

{{-- Mengisi konten halaman --}}
@section('content')

<div id="carouselExampleInterval" class="carousel slide carousel-container" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" >
      <img src="{{ asset('img/carousel/1.jpg') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/carousel/2.jpg') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/carousel/3.jpg') }}" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<br>
    <h2 class="mb-4">Produk Terbaru</h2>

    <div class="row">
        @forelse($latestproducts as $products)
            <div class="col-md-2 mb-3">
                <div class="card h-100">
                <img src="{{ asset('products/' . $products->image) }}" class="card-img-top" alt="{{ $products->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold">{{ $products->name }}</h5>
                    <p class="card-size text-secondary">Size {{ $products->size }}</p>
                    <p class="card-text text-danger">Rp {{ number_format($products->price) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                        @auth
                            <a href="#" class="btn btn-primary">Beli Sekarang</a>

                            <form action="{{ route('cart.add', $products) }}" method="POST">
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
        @empty
            <div class="col">
                <p class="text-center">Belum ada produk untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

@endsection