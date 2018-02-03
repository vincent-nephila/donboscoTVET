<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClassManagement\Helper as SectionHelper;

class Sectioning extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        
    }
    
    function viewsectioning($batch){
        $courses = \App\TvetCourse::all();
        
        return view('sectioning.index',compact('courses','batch'));
    }
    
    
    
    
//------------Ajax Section---------//    
    function get_courseStudents(Request $request){
        $batch = $request->batch;
        $course = $request->course;
        $students = SectionHelper::courseStudents($batch, $course);
        $field = "courseStudents";
        return view('ajax.sectioning',compact('students','field'));
    }
    
    function getcourseSections(Request $request){
        $batch = $request->batch;
        $course = $request->course;
        $field = "courseSections";
        
        $sections = \App\TvetSection::where('batch',$batch)->where('course_id',$course)->get();
        
        return view('ajax.sectioning',compact('sections','field'));
    }
    
    function getSectionsStudents(Request $request){
        $batch = $request->batch;
        $course = $request->course;
        $section = $request->section;
        $field = "courseSectionStudents";
        
        $sectionInfo = \App\TvetSection::where('batch',$batch)->where('course_id',$course)->where('section',$section)->first();
        $students = SectionController::sectionStudents($sectionInfo);
        
        return view('ajax.sectioning',compact('students','field'));
    }
    
    function update_studentSection(Request $request){
        $batch = $request->batch;
        $course = $request->course;
        $section = $request->section;
        $student = $request->student;
        
        $courseInfo = \App\TvetCourse::where('course_id',$course)->first();
        $sectionInfo = \App\TvetSection::where('section',$section)->where('course_id',$course)->where('batch',$batch)->first();
        
        $this->setSection($student,$section,$courseInfo,$batch);
                $this->setStudentClasses($batch,$student,$sectionInfo);
    }
    
    function setSection($student,$section,$courseInfo,$batch){
        \App\Status::where('period',$batch)->where('course',$courseInfo->course)->where('idno',$student)->update(['section'=>$section]);
    }
    
    function setStudentClasses($batch,$student,$section){
        $subjects = \App\TvetGrade::where('idno',$student)->where('batch',$batch)->get();
        
        foreach($subjects as $subject){
            $class = \App\TvetSectionClasses::where('subject_code',$subject->subject_code)->where('section_id',$section->id)->first();
            $subject->section = $class->assignedClass->section;
            $subject->save();
            
        }
        
        return null;
    }
}
