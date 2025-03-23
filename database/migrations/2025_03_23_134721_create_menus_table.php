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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('no_menu');
            $table->string('nama'); // Nama menu
            $table->text('deskripsi'); // Deskripsi menu
            $table->integer('harga'); // Harga menu dengan 2 desimal
            $table->unsignedBigInteger('kategori_id'); // Kategori menu (foreign key)
            $table->string('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
