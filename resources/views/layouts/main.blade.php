<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyShop | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        body {
            padding-top: 70px;
        }

        .card-img-top {
        width: 100%; /* Pastikan lebar gambar selalu penuh */
        aspect-ratio: 1 / 1; /* Membuat rasio aspek 1:1 (persegi). Coba juga 4 / 3 */
        object-fit: contain; /* 'contain' menunjukkan seluruh produk, 'cover' akan memotong */
        background-color: #fff; /* Memberi background putih jika ada ruang kosong */
    }
    </style>
</head>
<body>

    <nav class="navbar fixed-top navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="{{ route('home') }}">EasyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">


                <div class="d-flex align-items-center w-50 mx-auto">
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
                            <span class="input-group-text">
                                <span class="material-symbols-outlined">search</span>
                            </span>
                            <input type="text" class="form-control" name="query" placeholder="Search on EasyShop" aria-label="Search" value="{{ request('query') }}">
                        </div>
                        <button class="btn btn-outline-primary ms-2" type="submit">Search</button>
                    </form>
                </div>

                <div class="d-flex align-items-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link">
                                <span class="material-symbols-outlined">
                                    shopping_cart
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-3">
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                            </li>
                            <li class="nav-item ms-2">
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                            </li>
                        @else
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