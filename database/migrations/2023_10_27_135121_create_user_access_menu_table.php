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
        Schema::create('user_access_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("id_jabatan", 200)->nullable(false);
            $table->string('sub_menu_id', 100)->nullable(false);


            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan');
            $table->foreign('sub_menu_id')->references('sub_menu_id')->on('user_sub_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_access_menu');
    }
};
