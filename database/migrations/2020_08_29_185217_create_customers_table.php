<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->unique();
            $table->string('usia', 26);
            $table->date('tanggalkunjungan');
            $table->string('keluhanutama', 255)->nullable();
            $table->string('tinggibadan', 5)->nullable();
            $table->string('beratbadan', 5)->nullable();
            $table->string('tekanandarah', 7)->nullable();
            $table->string('pernafasan', 3)->nullable();
            $table->string('detakjantung', 3)->nullable();
            $table->string('suhutubuh', 5)->nullable();
            $table->integer('selesai')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
