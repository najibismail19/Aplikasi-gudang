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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string("no_penjualan", 200)->nullable(false);
            $table->string("id_customer", 200)->nullable(false);
            $table->string("nik", 200)->nullable(false);
            $table->timestamp("tanggal_penjualan")->nullable(false);
            $table->bigInteger("total_keseluruhan")->nullable(false)->default(0);
            $table->text("deskripsi")->nullable(true);
            $table->boolean("status_penjualan")->nullable(false)->default(false);
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->primary(["no_penjualan"]);

            $table->foreign("nik")->on("karyawan")->references("nik");
            $table->foreign("id_customer")->on("customers")->references("id_customer");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
