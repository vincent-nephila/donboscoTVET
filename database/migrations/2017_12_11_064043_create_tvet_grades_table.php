<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->string('subject_name');
            $table->string('subject_code');
            $table->string('section');
            $table->integer('category');
            $table->float('percentage');
            $table->string('grade');
            $table->integer('order');
            $table->integer('sem');
            $table->string('course_id');
            $table->integer('batch');
            $table->softDeletes();
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
        Schema::drop('tvet_grades');
    }
}
