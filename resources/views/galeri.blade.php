
@extends('layout')

@section('konten')
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
  <div class="container-fluid bg-dark text-white py-3">
    <div class="row align-items-center">
      <div class="col-6">
        <p class="mb-0">Rumah Makan Podomoro</p>
      </div>
      <div class="col-6 text-end">
        <a href="/ubahpassword" class="btn btn-outline-light">Ubah Password</a>
        <a href="/logout" class="btn btn-danger">Keluar</a>
        <a href="{{ route('keranjang.index') }}" class="btn btn-warning">
          Keranjang ({{ session('keranjang') ? count(session('keranjang')) : 0 }})
        </a>
      </div>
    </div>
  </div>
</header>

<section class="menu-section py-5">
  <div class="container">
    <h2 class="text-center mb-5">Menu Hari Ini</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
     @foreach($barang as $item)
  <div class="col">
    <div class="card shadow-sm">
      <img src="{{ Storage::url($item->foto) }}" class="card-img-top" alt="{{ $item->nama_makanan }}">
      <div class="card-body">
        <h3 class="card-title">{{ $item->nama_makanan }}</h3>
        <p class="card-text">{{ $item->deskripsi }}</p>
        <p class="price fw-bold">{{ rupiah($item->harga) }}</p>
        <form action="{{ route('keranjang.tambah', $item->id) }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-primary">Tambahkan ke Keranjang</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
    </div>
  </div>
</section>

@endsection
