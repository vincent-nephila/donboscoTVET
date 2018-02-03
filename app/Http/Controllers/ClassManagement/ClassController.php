<?php

namespace App\Http\Controllers\ClassManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Personnel\AssignPersonnel;

class ClassController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
        
        static function classStudent($classInfo){
            $students = \App\TvetGrade::join('users as u','u.idno','=','tvet_grades.idno')
                    ->where('section',$classInfo->section)
                    ->where('batch',$classInfo->batch)
                    ->orderBy('u.lastname','ASC')
                    ->orderBy('u.firstname','ASC')
                    ->get();
            
            return $students;
        }
        
        function viewclass($id){
            $class = \App\TvetClass::find($id);
            $students = self::classStudent($class);
            $sections = \App\TvetSectionClasses::with('TvetSection')->where('class_id',$id)->get();
            $assignedSect = \App\TvetSectionClasses::where('class_id',$id)->get();
            
            return view('classManagement.viewClass',compact('class','students','assignedSect','sections'));
            
            
        }

	//Assign a class to a section's class
	function assignsubjectclass(Request $request){
		$attachement = new \App\TvetSectionClasses;
		$attachement->subject_code = $request->subject;
		$attachement->section_id = $request->section;
		$attachement->class_id = $request->get_section;
		$attachement->save();

		return back();
		
	}

	//Un-assign a class to a section's class
	function unassignsubjectclass($assignment_id){
		\App\TvetSectionClasses::find($assignment_id)->delete();

		return back();	
	}
        
        function assignclassteacher(Request $request){
            $assignment = \App\UsersPosition::where('idno',$request->adviser)->where('position_id',3)->first();
            if(!$assignment){
                $request->request->add(['personnel'=>$request->adviser,'position'=>3]);
                AssignPersonnel::addRole($request);
            }
            
            AssignPersonnel::assignTeacher($request->class,$request->adviser);
            return back();
        }
        
        //Remove whole class
        static function removeWholeClass($class){
            $students = \App\TvetGrade::where('section',$class->section)->where('batch',$class->batch)->get();
            foreach($students as $student){
                self::removeStudent($student->id);
            }
            
            return null;
        }
        
        //Remove student to class
        static function removeStudent($record_id){
            \App\TvetGrade::findOrfail($record_id)->update(['section'=>""]);
            
            return null;
        }
        
        
//----------------Ajax Field-------------------//

}
