@extends('layouts.admin')

@section('title', 'Produk Saya')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Produk Saya</h1>
            <a href="{{ route('user.products.create') }}" class="btn btn-primary">Tambah Produk</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Gambar</th> <th>Nama</th>
            <th>Harga</th>
            <th>Size</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" style="width: 80px;">
                </td>
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->price) }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <a href="{{ route('user.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('user.products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Anda belum memiliki produk.</td>
            </tr>
        @endforelse
    </tbody>
</table>
    </div>
@endsection