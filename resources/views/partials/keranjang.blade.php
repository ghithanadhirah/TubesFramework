<section class="keranjang-section py-4 bg-light">
    <div class="container">
        <h3>Keranjang Saya</h3>
        @php
            $keranjang = session('keranjang', []);
            $total = 0;
        @endphp

        @if(count($keranjang) > 0)
            <ul class="list-group mb-3">
                @foreach($keranjang as $id => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <img src="{{ Storage::url($item['foto']) }}" alt="{{ $item['nama_makanan'] }}" style="width:50px; height:50px; object-fit:cover;">
                            {{ $item['nama_makanan'] }} (x{{ $item['jumlah'] }})
                        </div>
                        <div>
                            {{ rupiah($item['harga'] * $item['jumlah']) }}
                        </div>
                    </li>
                    @php
                        $total += $item['harga'] * $item['jumlah'];
                    @endphp
                @endforeach
            </ul>
            <p><strong>Total: {{ rupiah($total) }}</strong></p>
            <a href="{{ route('keranjang.index') }}" class="btn btn-success">Lihat Keranjang</a>
        @else
            <p>Keranjang kosong.</p>
        @endif
    </div>
</section>
