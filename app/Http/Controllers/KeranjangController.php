<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu; //untuk akses kelas model barang

class KeranjangController extends Controller
{
    public function daftarbarang()
    {
        // ambil data barang
        $barang = Menu::all();
        // kirim ke halaman view
        return view('galeri',
                        [ 
                            'barang'=>$barang,
                        ]
                    ); 
    }
    
   public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('keranjang', compact('keranjang', 'total'));
    }

    // Menambahkan item ke keranjang
    public function tambah(Request $request, $id)
    {
        $barang = Menu::findOrFail($id);

        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
        } else {
            $keranjang[$id] = [
                "nama_makanan" => $barang->nama_makanan,
                "harga" => $barang->harga,
                "jumlah" => 1,
                "foto" => $barang->foto
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    // Menghapus item dari keranjang
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }
       public function checkout()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('checkout', compact('keranjang', 'total'));
    }
    public function kurang($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] -= 1;
            if ($keranjang[$id]['jumlah'] <= 0) {
                unset($keranjang[$id]);
            }
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('keranjang.index');
    }


    // Memproses pembayaran
  public function bayar(Request $request)
    {
        // Set Midtrans Configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Ambil data keranjang
        $keranjang = session()->get('keranjang', []);
        $items = [];
        $total = 0;

        foreach ($keranjang as $id => $item) {
            $subtotal = $item['harga'] * $item['jumlah'];
            $items[] = [
                'id' => $id,
                'price' => $item['harga'],
                'quantity' => $item['jumlah'],
                'name' => $item['nama_makanan'],
            ];
            $total += $subtotal;
        }

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => 'Pelanggan',
                'last_name' => 'Rumah Makan',
                'email' => 'pelanggan@rumahmakan.com',
                'phone' => '08123456789',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function konfirmasi()
    {
        $pesanan = session()->get('pesanan', []);

        return view('konfirmasi', compact('pesanan'));
    }
    public function bayarCash(Request $request)
{
    $keranjang = session()->get('keranjang', []);

    if(empty($keranjang)) {
        return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong!');
    }

    $total = 0;
    foreach ($keranjang as $item) {
        $total += $item['harga'] * $item['jumlah'];
    }

    // Simpan transaksi pembayaran cash ke DB (contoh)
    // Contoh model Transaksi: transaksi dengan total dan status 'cash'
    // Sesuaikan dengan model dan tabel di project-mu
    // \App\Models\Transaksi::create([
    //     'user_id' => auth()->id(),
    //     'total' => $total,
    //     'metode_pembayaran' => 'cash',
    //     'status' => 'lunas',
    // ]);

    // Kosongkan keranjang
    session()->forget('keranjang');

    return redirect()->route('keranjang.index')->with('success', 'Pembayaran tunai berhasil! Terima kasih.');
}
}