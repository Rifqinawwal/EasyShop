@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="container">
        <h1>Edit Produk: {{ $product->name }}</h1>

        <form action="{{ route('user.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" name="size" value="{{ old('size', $product->size) }}" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option selected disabled value="">Pilih Kategori...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk (Opsional)</label><br>
                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" class="mb-2" style="width: 150px;">
                <input class="form-control" type="file" id="image" name="image">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
@endsection