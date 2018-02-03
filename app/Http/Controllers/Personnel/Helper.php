<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Helper extends Controller
{
    function get_SectionCourse($batch){
    	$courses = \App\TvetSection::where('batch',$batch)->groupBy('course_id')->get();

    	$field = "section_course";
    	return view('ajax.assign',compact('courses','field'));
    }

    function get_SectionSection($batch,$course){
    	$sections = \App\TvetSection::where('batch',$batch)->where('course_id',$course)->get();

    	$field = "section_section";
    	return view('ajax.assign',compact('sections','field'));
    }
    
    function get_ClassSubjects($batch){
    	$subjects = \App\TvetSubjects::where('batch',$batch)->groupBy('subject_code')->orderBy('category')->orderBy('sort')->get()->groupBy('sem');
    	$field = "class_subject";
    	return view('ajax.assign',compact('subjects','field'));
    }
    
    function get_ClassClass($batch,$subject){
    	$classes = \App\TvetClass::where('batch',$batch)->where('subject',$subject)->get();
    	$field = "class_class";
    	return view('ajax.assign',compact('classes','field'));
    }
}
