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
        Schema::create('supplier', function (Blueprint $table) {
            $table->string("id_supplier", 100)->nullable(false);
            $table->string("nama", 100)->nullable(false);
            $table->string("kontak", 100)->nullable(false);
            $table->string("alamat", 100)->nullable(false);
            $table->text("deskripsi")->nullable(true);

            $table->primary(["id_supplier"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
