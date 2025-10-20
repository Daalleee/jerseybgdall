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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jersey_id');
            $table->unsignedBigInteger('user_id'); // pembeli
            $table->string('buyer_address'); // alamat pembeli
            $table->string('buyer_phone'); // nomor telepon pembeli
            $table->string('payment_proof')->nullable(); // bukti pembayaran
            $table->enum('type', ['pembelian', 'penjualan'])->default('pembelian'); // jenis transaksi
            $table->enum('status', ['pending', 'selesai', 'ditolak'])->default('pending');
            $table->timestamps();
            
            $table->foreign('jersey_id')->references('id')->on('jerseys')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
