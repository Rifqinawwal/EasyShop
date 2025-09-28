@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Profil</h3>
                </div>
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="card-body">
                        <div class="form-group text-center">
                            <img src="{{ Auth::user()->avatar ? asset('avatars/' . Auth::user()->avatar) : 'https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/img/user2-160x160.jpg' }}" 
                                 class="img-circle elevation-2" alt="User Image" style="width: 100px; height: 100px; object-fit: cover;">
                            <br>
                            <label for="avatar" class="mt-2">Ganti Foto Profil</label>
                            <input type="file" id="avatar" name="avatar" class="form-control mt-1">
                            @error('avatar')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                             @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                        @if (session('status') === 'profile-updated')
                            <span class="ms-3 text-success">Tersimpan.</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Password</h3>
                </div>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="update_password_current_password">Password Saat Ini</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control" required>
                            @error('current_password', 'updatePassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="update_password_password">Password Baru</label>
                            <input id="update_password_password" name="password" type="password" class="form-control" required>
                             @error('password', 'updatePassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                             @error('password_confirmation', 'updatePassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Password</button>
                         @if (session('status') === 'password-updated')
                            <span class="ms-3 text-success">Tersimpan.</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection