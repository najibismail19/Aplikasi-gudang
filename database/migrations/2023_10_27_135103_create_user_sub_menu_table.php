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
        Schema::create('user_sub_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->string("title", 100)->nullable(false);
            $table->string("url", 100)->nullable(false);
            $table->string("icon", 100)->nullable(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('user_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sub_menu');
    }
};
