<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClassManagement\ClassController;

class MainController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	function mainManagement(){
		//get Active Batches
		$batches = \App\CtrSchoolYear::where('active',1)->get();
		//Courses
		$courses = \App\TvetCourse::get();
		//Subjects
		$subjects = \App\TvetSubjects::get();
		//Advisers
		$advisers = \App\UsersPosition::query()
					->join('positions as p','p.position_id','=','users_positions.position_id')
					->where('p.department','=','TVET')
					->groupBy('users_positions.idno')->get(['*']);

		//Section and Classes
		$sections = \App\TvetSection::whereIn('batch',$batches->pluck('period')->toArray())->get();
		$classes = \App\TvetClass::whereIn('batch',$batches->pluck('period')->toArray())->get();
		return view('classManagement.class',compact('batches','courses','advisers','sections','subjects','classes'));
	}

	//Create section
	function createsection(Request $request){
		$this->validate($request,[
		    'batch' => 'required',
		    'course' => 'required',
		    'section' => 'required',
		]);

		$section = new \App\TvetSection();
		$section->section = $request->section;
		$section->course_id = $request->course;
		$section->adviser_id = $request->adviser;
		$section->batch = $request->batch;
		$section->save();

		return back();
	}
        //Create section
        
        //Delete section
	function deletesection($id){
		\App\TvetSection::find($id)->delete();
		return back();
	}
	//Delete section


	//Create Class
	function createclass(Request $request){
		$validator = $this->validate($request,[
		    'classbatch' => 'required',
		    'classsubject' => 'required',
		]);

		$count = \App\TvetClass::where('subject',$request->classsubject)->where('batch',$request->classbatch)->count();

		$class = new \App\TvetClass();
		$class->section = $request->classsubject."-".($count+1);
		$class->subject = $request->classsubject;
		$class->adviser = $request->classadviser;
		$class->batch = $request->classbatch;
		$class->save();

		return back();
	}
	//Create Class
        
        function deleteclass($id){
                
		$class = \App\TvetClass::find($id);
                
                $this->deleteLink($id,'class_id');
                ClassController::removeWholeClass($class);
                
                $class->delete();
                
		return back();
        }
        //Severe connection between section and subjets
        function deleteLink($id,$field){
            \App\TvetSectionClasses::where($field,$id)->delete();
        }
        

        

}
