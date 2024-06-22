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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->foreignId('idLaundry');
            $table->foreign('idLaundry')->references('idLaundry')->on('laundry')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('total_bayar');
            $table->integer('status_pembayaran');
            $table->integer('status_pengambilan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
