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
        Schema::create('detail_prakitan', function (Blueprint $table) {
            $table->string("no_prakitan", 200)->nullable(false);
            $table->string("kode_produk", 200)->nullable(false);
            $table->bigInteger("qty")->nullable(false)->default(0);


            $table->primary(["no_prakitan", "kode_produk"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_prakitan');
    }
};
