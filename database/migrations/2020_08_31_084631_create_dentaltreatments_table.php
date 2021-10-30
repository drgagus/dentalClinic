<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentaltreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentaltreatments', function (Blueprint $table) {
            $table->id();
            $table->integer('dentalrecord_id');
            $table->string('gigi', 50);
            $table->integer('diag_id');
            $table->string('imagebefore', 100)->nullable();
            $table->string('imageafter', 100)->nullable();
            $table->string('tindakan', 1000);
            $table->integer('cost_id')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('doktergigi')->nullable();
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
        Schema::dropIfExists('dentaltreatments');
    }
}
