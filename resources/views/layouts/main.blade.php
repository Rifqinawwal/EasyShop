<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyShop | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        /* Padding atas untuk desktop (1 baris navbar) */
        body {
            padding-top: 70px;
        }

        /* Padding atas untuk mobile (lebih besar karena ada 2 baris) */
        @media (max-width: 991.98px) {
            body {
                padding-top: 112px;
            }
        }
        
        /* Aturan CSS untuk gambar agar seragam */
        .card-img-top {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: contain;
            background-color: #fff;
        }

        .product-detail-img {
            max-width: 400px;
            max-height: 400px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand text-primary fw-bold" href="{{ route('home') }}">EasyShop</a>

                <div class="d-none d-lg-flex align-items-center w-50 mx-auto">
                    <ul class="navbar-nav me-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Category
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                @forelse($categories as $category)
                                    <li><a class="dropdown-item" href="{{ route('products.by_category', $category) }}">{{ $category->name }}</a></li>
                                @empty
                                    <li><a class="dropdown-item" href="#">Belum ada kategori</a></li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>
                    <form action="{{ route('search.index') }}" method="GET" class="d-flex w-100" role="search">
                        <div class="input-group">
                            <span class="input-group-text"><span class="material-symbols-outlined">search</span></span>
                            <input type="text" class="form-control" name="query" placeholder="Search on EasyShop" value="{{ request('query') }}">
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center ms-auto ms-lg-0">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-3 d-none d-lg-flex">
                        @guest
                            <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a></li>
                            <li class="nav-item ms-2"><a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
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

                <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <nav class="navbar bg-light py-2 border-bottom d-lg-none">
            <div class="container">
                <form action="{{ route('search.index') }}" method="GET" class="d-flex w-100" role="search">
                    <div class="input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">search</span></span>
                        <input type="text" class="form-control" name="query" placeholder="Cari produk..." value="{{ request('query') }}">
                    </div>
                </form>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>