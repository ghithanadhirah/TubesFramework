<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan'; // Nama tabel eksplisit

    protected $guarded = [];

    // Fungsi untuk generate ID karyawan secara otomatis saat creating
    protected static function booted()
    {
        static::creating(function ($karyawan) {
            $karyawan->id_karyawan ??= self::generateID();
        });
    }

    // Fungsi untuk membuat ID karyawan secara berurutan
    public static function generateID(): string
    {
        $last = self::whereNotNull('id_karyawan')
            ->orderBy('id_karyawan', 'desc')
            ->value('id_karyawan');

        $nextNumber = $last ? ((int) substr($last, 4)) + 1 : 1;

        return 'PGW' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }
}
