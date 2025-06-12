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
        Schema::create('coa', function (Blueprint $table) {
            $table->id();
            $table->string('header_akun');
            $table->string('kode_akun')->unique();
            $table->string('nama_akun');
            $table->enum('jenis_akun', ['Aset', 'Kewajiban', 'Modal', 'Pendapatan', 'Beban'])->default('Aset');
	    $table->enum('posisi_normal', ['Debit', 'Kredit']);
            $table->decimal('saldo_nominal', 15, 2); // Nominal saldo, misalnya 100000.00
	    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
    }
};