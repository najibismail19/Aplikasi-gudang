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
        Schema::create('login', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp("tanggal_login")->nullable(false);
            $table->string("nik", 200)->nullable(false);
            $table->timestamp("tanggal_logout")->nullable();
            $table->string("ip", 200)->nullable(false);
            $table->text("device")->nullable(false);
            $table->timestamp("create_at")->nullable(false)->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->foreign("nik")->on("karyawan")->references("nik");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login');
    }
};
