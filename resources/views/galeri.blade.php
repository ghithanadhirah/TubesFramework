@extends('layout')

@section('konten')
<head>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            font-family: 'Quicksand', sans-serif;
        }

        /* Glassmorphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .brand-title {
            letter-spacing: 2px;
            font-weight: 700;
            font-size: 2rem;
            color: #333;
        }

        /* Floating Cart Button */
        .btn-cart {
            position: relative;
            transition: box-shadow 0.3s, transform 0.3s;
        }

        .btn-cart:hover {
            box-shadow: 0 8px 30px rgba(255, 193, 7, 0.5);
            transform: translateY(-5px) scale(1.05);
        }

        /* Card Menu */
        .menu-card {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            animation: fadeInUp 0.7s forwards;
        }

        .menu-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15);
        }

        .menu-card img {
            height: 220px;
            object-fit: cover;
            border-bottom: 2px solid #f1f5f9;
        }

        .badge-price {
            background: linear-gradient(90deg, #ffb703 0%, #fb8500 100%);
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 1em;
            padding: 0.5em 1.5em;
            box-shadow: 0 2px 10px rgba(251, 133, 0, 0.2);
            margin-bottom: 1em;
            display: inline-block;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Animasi delay untuk setiap card */
        .menu-card { animation-delay: var(--delay); }

        /* Footer */
        .footer {
            background: rgba(30, 41, 59, 0.9);
            color: #fff;
            text-align: center;
            padding: 1.5em 0;
            margin-top: 3em;
            border-radius: 1.5em 1.5em 0 0;
            font-size: 1.1em;
            letter-spacing: 1px;
        }

        /* New styles for better layout */
        .menu-section {
            padding: 50px 0;
        }

        .menu-title {
            font-size: 2.5rem;
            color: #ffb703;
            margin-bottom: 30px;
        }

        .menu-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-card .btn {
            background-color: #fb8500;
            color: white;
            transition: background-color 0.3s;
        }

        .menu-card .btn:hover {
            background-color: #ffb703;
        }
    </style>
</head>

<body>
@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

<header>
    <div class="container-fluid glass-header py-4 mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 d-flex align-items-center gap-2">
                <i class="bi bi-egg-fried fs-2 text-warning"></i>
                <span class="brand-title">Rumah Makan Podomoro</span>
            </div>
            <div class="col-12 col-lg-6 text-lg-end mt-2 mt-lg-0">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person"></i> Akun
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="/ubahpassword"><i class="bi bi-key"></i> Ubah Password</a></li>
                        <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Keluar</a></li>
                    </ul>
                </div>
                <a href="{{ route('keranjang.index') }}" class="btn btn-warning btn-cart mb-1">
                    <i class="bi bi-cart"></i>
                    Keranjang
                    @php $jml = session('keranjang') ? count(session('keranjang')) : 0; @endphp
                    @if($jml > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $jml }}
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</header>


<section class="menu-section">
    <div class="container">
        <h2 class="text-center menu-title">
            <i class="bi bi-stars"></i> Menu Hari Ini
        </h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($barang as $i => $item)
            <div class="col">
                <div class="card shadow-sm h-100 border-0 menu-card" style="--delay: {{ 0.1 + $i*0.08 }}s;">
                    <img src="{{ Storage::url($item->foto) }}" class="card-img-top" alt="{{ $item->nama_makanan }}">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary mb-2">{{ $item->nama_makanan }}</h5>
                        <p class="card-text text-muted flex-grow-1" style="min-height:60px;">{{ $item->nama }}</p>
                        <span class="badge-price">{{ rupiah($item->harga) }}</span>
                        <form action="{{ route('keranjang.tambah', $item->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn w-100 shadow-sm">
                                <i class="bi bi-cart-plus"></i> Tambahkan ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection