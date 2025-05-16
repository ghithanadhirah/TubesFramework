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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade');
            $table->date('tanggal_gaji');
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('total_gaji', 15, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
