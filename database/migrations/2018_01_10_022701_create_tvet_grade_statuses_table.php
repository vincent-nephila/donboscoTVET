<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetGradeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_grade_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id');
            $table->string('report');
            $table->integer('semester');
            $table->string('currentlyIn');
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
        Schema::drop('tvet_grade_statuses');
    }
}
