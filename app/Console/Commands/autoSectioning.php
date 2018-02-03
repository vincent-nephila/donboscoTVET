<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class autoSectioning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoSection {batch}';

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
            $sections = \App\TvetSection::where('course_id',$course->course_id)->where('batch',$batch)->get();
            $students = \App\Status::where('period',$batch)->where('course',$course->course)->whereIn('status',array(2,3))->get();
            
            
            $index = 0;
            $sectionCount = $sections->count('id');
            foreach($students as $student){
                $section = $sections[$index];
                $this->info('Setting '.\Helper::getName($student->idno).'to '.$section->section);
                $student->section = $section->section;
                $student->save();
                $this->setClasses($batch,$student,$section,$course);
                $index++;
                
                if($index >= $sectionCount-1){
                    $index = 0;
                }
            }
        }
    }
    
    function setClasses($batch,$student,$section){
        $subjects = \App\TvetGrade::where('idno',$student->idno)->where('batch',$batch)->get();
        foreach($subjects as $subject){
            $class = \App\TvetSectionClasses::where('subject_code',$subject->subject_code)->where('section_id',$section->id)->first();
            $this->info('Assigning '.\Helper::getName($student->idno).'of '.$section->section.' to '.$class->assignedClass->section);
            $subject->section = $class->assignedClass->section;
            $subject->save();
            
        }
    }
}
