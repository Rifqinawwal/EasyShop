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

    <div class="p-5 mb-4 bg-light rounded-3 text-center">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Selamat Datang di EasyShop</h1>
            <p class="fs-4">Temukan berbagai produk fashion berkualitas dengan harga terjangkau.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Lihat Semua Produk</a>
        </div>
    </div>

    <h2 class="mb-4">Produk Terbaru</h2>

    <div class="row">
        @forelse($latestproducts as $products)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $products->name }}</h5>
                        <p class="card-text text-muted">Rp {{ number_format($products->price) }}</p>
                        <a href="#" class="btn btn-primary mt-auto">Lihat Detail</a>
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