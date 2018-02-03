<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject_name');
            $table->string('subject_code');
            $table->integer('category');
            $table->float('percentage');
            $table->string('course_id');
            $table->integer('batch');
            $table->integer('sem');
            $table->integer('sort');
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
        Schema::drop('tvet_subjects');
    }
}
