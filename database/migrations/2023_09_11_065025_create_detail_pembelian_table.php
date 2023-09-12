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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->string("no_pembelian", 200)->nullable(false);
            $table->string("kode_produk", 100)->nullable(false);
            $table->bigInteger("harga")->nullable(false)->default(0);
            $table->bigInteger("jumlah")->nullable(false)->default(0);
            $table->bigInteger("total_harga")->nullable(false)->default(0);

            $table->primary(["no_pembelian", "kode_produk"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
