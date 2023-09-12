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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string("nik", 200)->unique();
            $table->string("nama", 200)->nullable(false);
            $table->string('email')->unique();
            $table->string('password');
            $table->string("id_jabatan", 200)->nullable(false);
            $table->string("kontak", 200)->nullable();
            $table->string("alamat", 200)->nullable();
            $table->string("gambar_profile", 200)->nullable();
            $table->string("id_gudang", 200)->nullable(false);
            $table->rememberToken();
            $table->timestamps();

            $table->primary(['nik']);
            $table->foreign("id_jabatan")->on("jabatan")->references("id_jabatan");
            $table->foreign("id_gudang")->on("gudang")->references("id_gudang");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
