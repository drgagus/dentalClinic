<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontograms', function (Blueprint $table) {
            $table->id();
            $table->integer('den_id');
            $table->integer('kondisi');
            $table->integer('bukal');
            $table->integer('mesial');
            $table->integer('palatal');
            $table->integer('distal');
            $table->integer('oklusal');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('odontograms');
    }
}
