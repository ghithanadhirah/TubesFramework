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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->string('id_presensi')->unique();
            $table->foreignId('id_karyawan')->constrained('karyawan')->cascadeOnDelete();
            $table->dateTime('tanggal_hadir')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit'])->default('hadir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
