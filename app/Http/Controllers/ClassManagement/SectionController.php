<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Personnel\AssignPersonnel;

class SectionController extends Controller
{
    public function __construct(){
            $this->middleware('auth');
    }

    //View Details off the Section via ID
    function viewsection($id){
            $section = \App\TvetSection::find($id);
            $students = SectionController::sectionStudents($section);
            $subjects = \App\TvetSubjects::where('course_id',$section->course_id)
                                    ->orderBy('category')->orderBy('sort')->get()->groupBy('sem');


            return view('classManagement.viewSection',compact('section','students','subjects'));
    }
        
    function assignAdviser(Request $request){
        $assignment = \App\UsersPosition::where('idno',$request->adviser)->where('position_id',4)->first();
        if(!$assignment){
            $request->request->add(['personnel'=>$request->adviser,'position'=>4]);
            AssignPersonnel::addRole($request);
        }
        //return $request->personnel." ".$request->adviser;
        return AssignPersonnel::assignAdviser($request->section,$request->adviser);

    }
        
    static function sectionStudents($sectionInfo){
        $students = \App\Status::join('users as u','u.idno','=','statuses.idno')->select('statuses.*')->where('section',$sectionInfo->section)->where('period',$sectionInfo->batch)->where('course',$sectionInfo->tvetCourse->course)->orderBy('u.lastname','ASC')->orderBy('u.firstname','ASC')->get();

        return $students;
    }
        
}
