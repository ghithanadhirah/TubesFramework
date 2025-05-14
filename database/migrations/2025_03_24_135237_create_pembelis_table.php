<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembeli', function (Blueprint $table) {
            $table->id();  // Kolom ID Pembeli
            $table->string('nama');  // Nama Pembeli
            $table->string('alamat');  // Alamat Pembeli
            $table->string('nomor_telepon');  // Nomor Telepon Pembeli
            $table->string('email')->unique();  // Email Pembeli (unik)
            $table->enum('status', ['aktif', 'tidak aktif']);  // Status Pembeli
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembeli');
    }
};


