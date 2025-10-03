@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection