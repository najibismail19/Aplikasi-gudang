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
        Schema::create('prakitan', function (Blueprint $table) {
            $table->string("no_prakitan", 200)->nullable(false);
            $table->string("kode_produk", 200)->nullable(false);
            $table->string("nik", 200)->nullable(false);
            $table->timestamp("tanggal_rencana")->nullable(false);
            $table->timestamp("tanggal_actual_prakitan")->nullable();
            $table->bigInteger("qty_rencana")->nullable(false)->default(0);
            $table->bigInteger("qty_hasil")->nullable();
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->primary("no_prakitan");
            $table->foreign("kode_produk")->on("produk")->references("kode_produk");
            $table->foreign("nik")->on("karyawan")->references("nik");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakitan');
    }
};
