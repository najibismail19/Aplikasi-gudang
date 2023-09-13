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
        Schema::create('stok', function (Blueprint $table) {
            $table->string("id_gudang", 200)->nullable(false);
            $table->string("kode_produk", 200)->nullable(false);
            $table->bigInteger("stok")->nullable(false)->default(0);

            $table->primary(["id_gudang", "kode_produk"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
