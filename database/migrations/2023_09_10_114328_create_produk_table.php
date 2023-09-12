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
            $table->string("kode_produk", 100)->nullable(false);
            $table->string("nama", 100)->nullable(false);
            $table->string("satuan", 100)->nullable(false);
            $table->bigInteger("harga")->nullable(false)->default(0);
            $table->boolean("jenis")->nullable(false);
            $table->string("gambar", 200)->nullable();
            $table->text("deskripsi")->nullable();

            $table->primary(["kode_produk"]);
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
