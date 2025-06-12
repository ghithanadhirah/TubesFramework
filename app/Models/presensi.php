<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $guarded = [];

     protected static function booted()
    {
        static::creating(function ($karyawan) {
            $karyawan->id_presensi ??= self::generateID();
        });
    }

    public static function generateID(): string
    {
        $last = self::whereNotNull('id_presensi')
            ->orderBy('id_presensi', 'desc')
            ->value('id_presensi');

        $nextNumber = $last ? ((int) substr($last, 4)) + 1 : 1;

        return 'PRS' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }

    public function karyawan()
    {
        return $this->belongsTo(karyawan::class, 'id_karyawan');
    }
}
