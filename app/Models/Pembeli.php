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

   
}