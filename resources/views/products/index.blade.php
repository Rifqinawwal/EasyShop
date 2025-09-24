{{-- Menggunakan file layout utama --}}
@extends('layouts.main')

{{-- Mengisi judul halaman --}}
@section('title', 'Daftar Produk')

{{-- Mengisi konten halaman --}}
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Produk Kami</h1>
        {{-- Nanti di sini bisa ditambahkan tombol "Tambah Produk" --}}
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info">
            Belum ada produk saat ini.
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        {{-- <img src="..." class="card-img-top" alt="{{ $product->name }}"> --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">Rp {{ number_format($product->price) }}</p>
                            <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                            <a href="#" class="btn btn-primary mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection