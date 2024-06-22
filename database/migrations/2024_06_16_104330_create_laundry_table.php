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
        Schema::create('laundry', function (Blueprint $table) {
            $table->id('idLaundry');
            $table->unsignedBigInteger('name_id');
            $table->foreign('name_id')->references('idUser')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name_customer', 255);
            $table->string('no_hp', 25);
            $table->string('alamat', 255);
            $table->string('jenisLayanan', 255);
            $table->string('berat', 255);
            $table->date('tgl_terima');
            $table->date('tgl_selesai');
            $table->string('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry');
    }
};
