<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function view($course_id){
        $batch = \App\CtrSchoolYear::where('active',1)->get()->pluck('period')->toArray();
        $sections = \App\TvetSection::where('course_id',$course_id)->whereIn('batch',$batch)->get();
        $course = \App\TvetCourse::where('course_id',$course_id)->first();
        
        return view('classManagement.viewCourse',  compact('sections','course'));
    }
}
