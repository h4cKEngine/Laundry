<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->datetime('orario');
            $table->foreignId('id_user')->references('id')->on('users')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_washer')->references('id')->on('washers')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_washing_program')->references('id')->on('washing_programs')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
