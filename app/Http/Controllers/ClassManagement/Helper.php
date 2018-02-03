<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class Helper extends Controller
{
    function get_BatchSubjects($batch){
    	$subjects = \App\TvetSubjects::where('batch',$batch)->groupBy('subject_code')->orderBy('category')->orderBy('sort')->get()->groupBy('sem');
    	$field = "batch_subjects";
    	return view('ajax.classmanagement',compact('subjects','field'));
    }

    function getAvailableClass(){
	  	$subject = Input::get('subject');
	  	$batch = Input::get('batch');
	  	$section = Input::get('section');

	  	$classes = \App\TvetClass::where('subject',$subject)->where('batch',$batch)->get();

	  	return view('ajax.viewSection',compact('section','subject','classes','batch'));
    }
    
    function getAdvisers($classid){
        $advisers = \App\UsersPosition::with('User')->whereHas('Position',function($q){
            $q->where('department','TVET');
        })->join('users as u','u.idno','=','users_positions.idno')->groupBy('u.idno')->orderBy('firstname','ASC')->orderBy('lastname','ASC')->get();
        $field = "adviser_list";
        return view('ajax.viewClass',  compact('classid','advisers','field'));
    }
    
    static function courseStudents($batch,$course){
        $courses = \App\TvetCourse::where('course_id',$course)->first();
        return \App\Status::join('users as u','u.idno','=','statuses.idno')->select('statuses.*')->whereIn('statuses.status',array(2,3))->where('period',$batch)->where('course',$courses->course)->orderBy('u.lastname','ASC')->orderBy('u.firstname','ASC')->get();
        
    }
   
}
