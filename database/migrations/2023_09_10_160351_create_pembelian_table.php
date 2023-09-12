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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string("no_pembelian", 200)->nullable(false);
            $table->string("nik", 200)->nullable(false);
            $table->string("id_supplier", 100)->nullable(false);
            $table->timestamp("tanggal_pembelian")->nullable(false);
            $table->bigInteger("total_keseluruhan")->nullable(false)->default(0);
            $table->text("deskripsi")->nullable(true);
            $table->boolean("status_pembelian")->nullable(false)->default(false);
            $table->boolean("status_penerimaan")->nullable(false)->default(false);
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->primary(["no_pembelian"]);

            $table->foreign("nik")->on("karyawan")->references("nik");
            $table->foreign("id_supplier")->on("supplier")->references("id_supplier");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
