<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kartu_stok', function (Blueprint $table) {
            $table->string("id_gudang", 200)->nullable(false);
            $table->string("kode_produk", 200)->nullable(false);
            $table->string("no_referensi")->nullable(false);
            $table->timestamp("tanggal")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->bigInteger("saldo_awal")->nullable(false)->default(0);
            $table->bigInteger("stock_in")->nullable(false)->default(0);
            $table->bigInteger("stock_out")->nullable(false)->default(0);
            $table->bigInteger("saldo_akhir")->nullable(false)->default(0);
            $table->text("deskripsi")->nullable();

            $table->foreign("id_gudang")->on("gudang")->references("id_gudang");
            $table->foreign("kode_produk")->on("produk")->references("kode_produk");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_stok');
    }
};
