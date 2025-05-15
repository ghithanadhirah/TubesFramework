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
        Schema::create('kategori_menus', function (Blueprint $table) {
            $table->id();
            $table->string("id_kategori")->unique();
            $table->string("nama_kategori");
            $table->boolean("status")->default(true); // Menandai kategori aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_menus');
    }
};
