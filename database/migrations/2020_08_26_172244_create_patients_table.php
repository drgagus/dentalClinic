<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            $table->integer('nomorrekammedis');
            $table->string('nik', 16)->nullable();
            $table->string('nama', 50);
            $table->string('jeniskelamin', 10);
            $table->string('tempatlahir', 30)->nullable();
            $table->date('tanggallahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('pendidikan', 30)->nullable();
            $table->string('pekerjaan', 30)->nullable();
            $table->string('alamat',100)->nullable();
            $table->integer('nomortelepon')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
