<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class addAttitude extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setattitude {batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $batch = $this->argument('batch');
        $courses = \App\TvetCourse::get();
        $attitude = \App\TvetAttitude::all();
        
        foreach($courses as $course){
            $students = \App\Status::where('period',$batch)->where('course',$course->course)->whereIn('status',array(2,3))->get();
            
            foreach($students as $student){
                $this->setAttitude($student,$attitude);
            }
        }
    }
    
    function setAttitude($student,$attitudes){
        foreach($attitudes as $attitude){
            $newAttend = new \App\TvetAttitudeResult();
            $newAttend->attitude_id = $attitude->id;
            $newAttend->idno = $student->idno;
            $newAttend->batch = $student->period;
            $newAttend->semester = 1;
            $newAttend->save();
        }
    }
}
