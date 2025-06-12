@extends('layout')

@section('konten')
<div class="container py-5">
    <h2>Keranjang Belanja</h2>
    @php
        $keranjang = session('keranjang', []);
        $total = 0;
    @endphp

    @if(count($keranjang) > 0)
        <table class="table table-striped mb-4">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Makanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang as $id => $item)
                    <tr>
                        <td><img src="{{ Storage::url($item['foto']) }}" style="width: 70px; height: 70px; object-fit:cover;"></td>
                        <td>{{ $item['nama_makanan'] }}</td>
                        <td>{{ rupiah($item['harga']) }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('keranjang.kurang', $id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">-</button>
                                </form>
                                {{ $item['jumlah'] }}
                                <form action="{{ route('keranjang.tambah', $id) }}" method="POST" class="ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ rupiah($item['harga'] * $item['jumlah']) }}</td>
                        <td>
                            <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $total += $item['harga'] * $item['jumlah'];
                    @endphp
                @endforeach
            </tbody>
        </table>

        <h4>Total: {{ rupiah($total) }}</h4>
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        <button id="cash-button" class="btn btn-success ms-2">Bayar Tunai</button>

        <!-- Tambahkan Midtrans Snap JS -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function() {
                fetch('{{ route("keranjang.bayar") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        snap.pay(data.snapToken);
                    } else {
                        alert('Terjadi kesalahan: ' + data.error);
                    }
                });
            });
        </script>

    @else
        <p>Keranjang masih kosong.</p>
        <a href="/depan" class="btn btn-primary">Belanja Sekarang</a>
    @endif
</div>
@endsection