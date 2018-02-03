<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createClasses {batch}';

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
            $sections = \App\TvetSection::where('course_id',$course->course_id)->get();
            $subjects = \App\TvetSubjects::where('course_id',$course->course_id)->get();
            foreach($sections as $section){
                $this->info('Creating class for '.$section->section);
                foreach($subjects as $subject){
                    $class = $this->createClass($subject,$batch);
                    $this->assignClass($section->id,$class->id,$subject->subject_code);
                    $this->info('Assigning '.$class->section." to ".$section->section);
                }
            }
        }
    }
    
    function createClass($subject,$batch){
        $count = \App\TvetClass::where('subject',$subject->subject_code)->where('batch',$batch)->count();
        
        $class = new \App\TvetClass();
        $class->section = $subject->subject_code." - ".($count+1);
        $class->subject = $subject->subject_code;
        $class->batch = $batch;
        $class->save();
        
        return $class;
    }
    
    function assignClass($section_id,$class_id,$subject_code){
		$attachement = new \App\TvetSectionClasses;
		$attachement->subject_code = $subject_code;
		$attachement->section_id = $section_id;
		$attachement->class_id = $class_id;
		$attachement->save();
    }
}
