<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan'; // Nama tabel eksplisit

    protected $guarded = []; //semua kolom boleh di isi

    public static function getKodeKaryawan()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(id_karyawan), 'KRY-00000') as id_karyawan
                FROM Karyawan ";
        $idkaryawan = DB::select($sql);

        // cacah hasilnya
        foreach ($idkaryawan as $kdkrywn) {
            $kd = $kdkrywn->id_karyawan;
        }
        // Mengambil substring tiga digit akhir dari string
        $noawal = substr($kd,-5);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'KRY-'.str_pad($noakhir,5,"0",STR_PAD_LEFT); //menyambung dengan string 
        return $noakhir;

    }


    
}
