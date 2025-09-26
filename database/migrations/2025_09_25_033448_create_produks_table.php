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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();

            $table->string('kode_produk', 20)->unique();
            $table->string('nama_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->string('size', 20)->nullable();
            $table->string('satuan', 20)->nullable();
            $table->decimal('harga', 12, 2)->default(0);

            $table->integer('stok')->default(0);
            $table->integer('sisa_stok')->default(0);

            $table->string('image', 255)->nullable();

            // relasi ke kategori
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
