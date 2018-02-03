<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvetAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvet_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->integer('batch');
            $table->integer('sem');
            $table->string('type');
            $table->string('name');
            $table->integer('order');
            $table->float('jan',8,2);
            $table->float('feb',8,2);
            $table->float('mar',8,2);
            $table->float('apr',8,2);
            $table->float('may',8,2);
            $table->float('jun',8,2);
            $table->float('jul',8,2);
            $table->float('aug',8,2);
            $table->float('sep',8,2);
            $table->float('oct',8,2);
            $table->float('nov',8,2);
            $table->float('dec',8,2);
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
        Schema::drop('tvet_attendances');
    }
}
