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
        Schema::create('laporan_pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('pesanan_id')->primary(); // Primary Key dari pesanan_id
            $table->string('kode_pesanan', 20);
            $table->string('pembeli', 100);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('harga_pengiriman', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->integer('kode_unik');
            $table->enum('status_bayar', ['not paid', 'paid', 'pending'])->default('pending');
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->enum('status_verifikasi', ['manual', 'otomatis', 'belum'])->default('belum');
            $table->string('status_pengiriman', 7)->nullable();
            $table->string('no_resi', 50)->nullable();
            $table->string('ekspedisi', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Relasi ke tabel pesanan
            $table->foreign('pesanan_id')
                  ->references('id')
                  ->on('pesanan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pesanan');
    }
};
