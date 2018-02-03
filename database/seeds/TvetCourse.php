<?php

use Illuminate\Database\Seeder;

class TvetCourse extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('tvet_courses')->insert([
        	[
        		'course'=>'AUTOMOBILE MECHANIC',
        		'course_id'=>'AMC'
        		],
        	[
        		'course'=>'ELECTRO MECHANICAL TECHNICIAN',
        		'course_id'=>'EMT'
        		],
        	[
        		'course'=>'FITTER MACHINIST',
        		'course_id'=>'FM'
        		],
        	[
        		'course'=>'PRINTING TECHNOLOGY',
        		'course_id'=>'PT'
        		],
        	[
        		'course'=>'REFRIGERATION AND AIRCONDITIONING MECHANIC ',
        		'course_id'=>'RACM'
        		]
        	]);
    }
}
