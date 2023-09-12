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
        Schema::create('penerimaan', function (Blueprint $table) {
            $table->string("no_penerimaan", 200)->nullable(false);
            $table->string("no_pembelian", 200)->nullable(false);
            $table->string("nik", 200)->nullable(false);
            $table->timestamp("tanggal_penerimaan")->nullable(false);
            $table->text("deskripsi")->nullable();
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->primary("no_penerimaan");
            $table->foreign("no_pembelian")->on("pembelian")->references("no_pembelian");
            $table->foreign("nik")->on("karyawan")->references("nik");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan');
    }
};
