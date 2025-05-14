<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan'; // Nama tabel eksplisit

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($karyawan) { // Mengubah $pegawai menjadi $karyawan
            $karyawan->id_karyawan ??= self::generateID();
        });
    }

    public static function generateID(): string
    {
        $last = self::whereNotNull('id_karyawan')
            ->orderBy('id_karyawan', 'desc')
            ->value('id_karyawan');

        $nextNumber = $last ? ((int) substr($last, 3)) + 1 : 1;

        return 'PGW' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT); // Mengubah padding dari 2 menjadi 4
    }
}