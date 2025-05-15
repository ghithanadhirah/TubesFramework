<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $table = 'kategori_menus'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getIdKategori()
    {
        // Query untuk mendapatkan ID kategori terakhir
        $sql = "SELECT IFNULL(MAX(id_kategori), 'KM000') as id_kategori
                FROM kategori_menus";
        $idKategori = DB::select($sql);

        // Mengambil hasil query
        foreach ($idKategori as $idkat) {
            $id = $idkat->id_kategori;
        }

        // Mengambil substring tiga digit akhir dari string KM000
        $nomor1 = substr($id, -3);
        $nomor2 = $nomor1 + 1; // Menambahkan 1, hasilnya adalah integer ex: 1
        $nomakhir = 'KM' . str_pad($nomor2, 3, "0", STR_PAD_LEFT); // Format kembali dengan string KM001
        return $nomakhir;
    }
}