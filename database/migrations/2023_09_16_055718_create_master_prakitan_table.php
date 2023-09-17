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
        Schema::create('master_prakitan', function (Blueprint $table) {
            $table->string("kode_produk_jadi", 200)->nullable(false);
            $table->string("kode_produk_mentah", 200)->nullable(false);
            $table->bigInteger("quantity")->nullable(false)->default(0);
            $table->boolean("is_active")->nullable(false)->default(false);
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->primary(["kode_produk_jadi", "kode_produk_mentah"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_prakitan');
    }
};
