<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyShop | @yield('title')</title>

     <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary fw-bold" href="{{ route('home') }}">EasyShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
    </ul>

    <div class="d-flex align-items-center mx-auto">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search"  placeholder="Search on EasyShop" aria-label="Search" style="width: 500px;">
            <button class="btn btn-outline-primary" type="submit">Search</button> </form>

        <ul class="navbar-nav">
    <li class="nav-item">
        <a href="#" class="nav-link">
            <span class="material-symbols-outlined">
                shopping_cart
            </span>
        </a>
    </li>
</ul>

<ul class="navbar-nav ms-5 auth-buttons">
    @guest
        {{-- TAMPILKAN INI HANYA JIKA PENGGUNA ADALAH TAMU (BELUM LOGIN) --}}
        <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
        </li>
        <li class="nav-item ms-2">
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
        </li>
    @else
        {{-- TAMPILKAN INI JIKA PENGGUNA SUDAH LOGIN --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    @endguest
</ul>
    </div>
</div>
    </div>
</nav>

    <main class="container mt-4">
        @yield('content')
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>