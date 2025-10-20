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
        Schema::create('jerseys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('size'); // S, M, L, XL
            $table->enum('condition', ['baru', 'bekas']); // kondisi jersey
            $table->string('photo')->nullable(); // path foto jersey
            $table->string('address'); // alamat penjual
            $table->string('phone_number'); // nomor telepon penjual
            $table->enum('status', ['pending_review', 'aktif', 'ditolak'])->default('pending_review');
            $table->enum('type', ['sistem', 'pelanggan'])->default('pelanggan'); // jersey milik sistem atau pelanggan
            $table->unsignedBigInteger('user_id')->nullable(); // ID penjual (jika dari pelanggan)
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jerseys');
    }
};
