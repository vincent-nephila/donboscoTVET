<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loadStudents {batch}';

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
        
        foreach($courses as $course){
            $students = \App\Status::where('period',$batch)->where('course',$course->course)->whereIn('status',array(2,3))->get();
            $subjects = \App\TvetSubjects::where('course_id',$course->course_id)->get();
            foreach($students as $student){
                $this->info('Adding '.\App\Helpers\Helper::getName($student->idno).' of '.$course->course);
                foreach($subjects as $subject){
                    $this->addSubjects($student,$subject);
                    
                }
            }
        }
        $this->info('Done!!!!');
    }
    
    function addSubjects($student,$course){
        $record = new \App\TvetGrade();
        $record->idno = $student->idno;
        $record->subject_name = $course->subject_name;
        $record->subject_code = $course->subject_code;
        $record->category = $course->category;
        $record->percentage = $course->percentage;
        $record->order = $course->sort;
        $record->course_id = $course->course_id;
        $record->batch = $student->period;
        $record->sem = $course->sem;
        $record->save();
    }
}
