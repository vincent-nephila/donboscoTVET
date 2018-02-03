<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetSchoolDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_school_days', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_id');
            $table->string('batch');
            $table->integer('sem');
            $table->string('month');
            $table->string('month_short');
            $table->float('days',8,2);
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
        Schema::drop('tvet_school_days');
    }
}
