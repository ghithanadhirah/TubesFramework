<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembelis'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKdPembeli()
    {
        // Query untuk mendapatkan ID pembeli terakhir
        $sql = "SELECT IFNULL(MAX(kode_pembeli), 'PB000') as kode_pembeli FROM pembelis";
        $kdPembeli = DB::select($sql);

        // Mengambil hasil query
        foreach ($kdPembeli as $kdp) {
            $kd = $kdp->kode_pembeli;
        }

        // Mengambil substring tiga digit akhir dari string PB000
        $nomor1 = substr($kd, -3);
        $nomor2 = $nomor1 + 1; // Menambahkan 1, hasilnya adalah integer ex: 1
        $nomakhir = 'PB' . str_pad($nomor2, 3, "0", STR_PAD_LEFT); // Format kembali dengan string PB001
        return $nomakhir;
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'pembeli_id');
    }
}