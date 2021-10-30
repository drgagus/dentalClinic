<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentalrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentalrecords', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->date('tanggalkunjungan');
            $table->integer('usiatahun');
            $table->integer('usiabulan');
            $table->integer('usiahari');
            $table->string('keluhanutama', 255)->nullable();
            $table->string('tinggibadan', 5)->nullable();
            $table->string('beratbadan', 5)->nullable();
            $table->string('tekanandarah', 7)->nullable();
            $table->string('pernafasan', 3)->nullable();
            $table->string('detakjantung', 3)->nullable();
            $table->string('suhutubuh', 4)->nullable();
            $table->string('pemeriksaansubjektif', 1000)->nullable();
            $table->string('pemeriksaanobjektif', 1000)->nullable();
            $table->string('diagnosa', 500)->nullable();
            $table->string('informedconsent', 100)->nullable();
            $table->string('pengobatan', 100)->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('dentalrecords');
    }
}
