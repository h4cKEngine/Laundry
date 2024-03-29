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
        Schema::create('washing_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('prezzo');
            $table->time('durata');
            $table->boolean('stato')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('washing_programs');
    }
};
