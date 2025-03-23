<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//tambahan
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus'; // Nama tabel eksplisit

    protected $guarded = []; // Semua atribut bisa diisi secara massal

    public static function getNoMenu()
    {
        // Query untuk mendapatkan kode menu terakhir
        $sql = "SELECT IFNULL(MAX(no_menu), 'MNU000') as no_menu FROM menus";
        $nomenu = DB::select($sql);

        // Ambil hasil query
        foreach ($nomenu as $nomn) {
            $no = $nomn->no_menu;
        }

        // Mengambil tiga digit akhir dari kode menu
        $noAwal = substr($no, -3);
        $noAkhir = $noAwal + 1; // Menambahkan 1 ke nomor terakhir
        $noAkhir = 'MNU' . str_pad($noAkhir, 3, "0", STR_PAD_LEFT); // Format nomor baru

        return $noAkhir;
    }

    // Mutator untuk harga menu, menghapus koma sebelum menyimpan ke database
    public function setPriceAttribute($value)
    {
        $this->attributes['harga'] = str_replace(',', '', $value);
    }
}
