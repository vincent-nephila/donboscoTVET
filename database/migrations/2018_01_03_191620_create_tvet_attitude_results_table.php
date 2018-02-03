<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetAttitudeResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_attitude_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attitude_id');
            $table->string('idno');
            $table->string('batch');
            $table->integer('semester');
            $table->string('rating');
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
        Schema::drop('tvet_attitude_results');
    }
}
