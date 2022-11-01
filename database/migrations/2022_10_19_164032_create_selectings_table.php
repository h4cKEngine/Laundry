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
        Schema::create('selectings', function (Blueprint $table) {
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
        Schema::dropIfExists('selectings');
    }
};
