<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi')->unique();
            $table->string('nomor_faktur')->nullable();
            $table->string('penyedia')->nullable();
            $table->string('pelanggan')->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->double('sub_total');
            $table->double('diskon')->default(0);
            $table->double('total');
            $table->double('bayar')->nullable();
            $table->enum('jenis', ['penjualan', 'pembelian']);
            $table->timestamp('created_at');
            $table->timestamp('final_at')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
