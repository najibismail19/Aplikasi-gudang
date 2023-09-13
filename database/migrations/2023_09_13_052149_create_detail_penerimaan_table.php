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
        Schema::create('detail_penerimaan', function (Blueprint $table) {
            $table->string("no_penerimaan", 200)->nullable(false);
            $table->string("kode_produk", 100)->nullable(false);
            $table->bigInteger("jumlah")->nullable(false)->default(0);

            $table->primary(["no_penerimaan", "kode_produk"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penerimaan');
    }
};
