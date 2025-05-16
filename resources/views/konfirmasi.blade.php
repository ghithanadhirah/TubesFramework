@extends('layout')

@section('konten')
<div class="container py-5">
    <h2>Konfirmasi Pembayaran</h2>

    @if(session('pesanan'))
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Nama:</strong> {{ session('pesanan')['nama'] }}</li>
            <li class="list-group-item"><strong>Alamat:</strong> {{ session('pesanan')['alamat'] }}</li>
            <li class="list-group-item"><strong>Nomor HP:</strong> {{ session('pesanan')['nomor_hp'] }}</li>
            <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ session('pesanan')['metode_pembayaran'] }}</li>
            <li class="list-group-item"><strong>Total Bayar:</strong> {{ rupiah(session('pesanan')['total']) }}</li>
        </ul>
        <a href="/" class="btn btn-success">Belanja Lagi</a>
    @else
        <p>Pesanan tidak ditemukan.</p>
        <a href="/" class="btn btn-primary">Belanja Sekarang</a>
    @endif
</div>
@endsection
