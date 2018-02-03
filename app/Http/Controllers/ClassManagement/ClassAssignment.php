<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassAssignment extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function viewClassification($batch){
        $subjects = \App\TvetGrade::where('batch',$batch)->groupBy('subject_code')->get();
        
        return view('classAssignment.index',compact('subjects','batch'));
    }
    
//----------------AJAX Part----------------//
    
    function get_subjectStudent(Request $request){
        $batch = $request->batch;
        $subject = $request->subject;
        $field = "classStudents";
        
        $students = \App\TvetGrade::where('batch',$batch)->where('subject_code',$subject)->get();
        
        return view('ajax.classAssignment',compact('field','students','batch'));
        
    }
    
    function get_subjectClasses(Request $request){
        $batch = $request->batch;
        $subject = $request->subject;
        $field = "subjectClasses";
        
        $classes = \App\TvetClass::where('batch',$batch)->where('subject',$subject)->get();
        
        return view('ajax.classAssignment',compact('field','classes'));
        
    }
    
    function get_classInfo(Request $request){
        $batch = $request->batch;
        $subject = $request->subject;
        $class = $request->class;
        $field = "classInfo";
        
        $classInfo = \App\TvetClass::where('batch',$batch)->where('subject',$subject)->where('section',$class)->first();
        $attachedSection = \App\TvetSectionClasses::with('TvetSection')->where('class_id',$classInfo->id)->get();
        
        return view('ajax.classAssignment',compact('field','classInfo','attachedSection'));
    }
    
    function get_classStudents(Request $request){
        $batch = $request->batch;
        $subject = $request->subject;
        $class = $request->class;
        $field = "sectionStudents";
        
        $students = \App\TvetGrade::where('batch',$batch)->where('subject_code',$subject)->where('section',$class)->get();
        
        return view('ajax.classAssignment',compact('field','students'));
        
    }
    
    function update_studentClass(Request $request){
        $class = $request->class;
        $record = $request->student;
        
        \App\TvetGrade::find($record)->update(['section'=>$class]);
    }
}
