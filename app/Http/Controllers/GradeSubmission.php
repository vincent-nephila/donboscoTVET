<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\ClassManagement\ClassController;

class GradeSubmission extends Controller
{
    public function __construct(){
        $this->middleware(['auth',]);
    }
    
    function viewClassGrades($id){
        $class = \App\TvetClass::find($id);
        
        //Summon all the students hahaha
        $students = ClassController::classStudent($class);
        
        
        if(!($this->isAdviser($class->adviser))){
            return back()->withErrors(['warning'=>'You are trying to access / change data that is unavailable to you.']);
        }
        
        
        if(($class->submissionLocked == 1) || $this->isDue($class)){
            return view('grades.viewgrade',compact('class','students'));
        }else{
            return view('grades.editgrade',compact('class','students','id'));
        }
        
    }
    
    function updateGrade(Request $request){
        $grade = $request->grade;
        $record_id = $request->id ;
        
        \App\TvetGrade::find($record_id)->update(['grade'=>$grade]);
        
        return $record_id;
        
    }
    
    public static function changeGradeField($recordId,$grade){
        \App\TvetGrade::find($recordId)->update(["grade"=>$grade]);
    }
    
    function submitandLockGrades($class_id){
        $class = \App\TvetClass::find($class_id);
        
        if($this->isAdviser($class->adviser)){
            $class->update(['submissionLocked'=>1]);
            return back();
        }else{
            
            return back()->withErrors(['warning'=>'You are trying to access / change data that is unavailable to you.']);
        }
    }
    
    
    
    
    
    function isAdviser($adviser){
        $user = \Auth::user()->idno;
        if($adviser == $user){
            return true;
        }else{
            return false;
        }
    }
    
    function isDue($class){
        if(class_exists('SubmissionTimer')){
            $subject = \App\TvetSubjects::where('subject_code',$class->subject_code);
            $timer = \App\SubmissionTimer::where('sem',$subject->sem)->where('batch',$class->batch)->last();
            
            if($timer){
                if(strtotime(\Carbon\Carbon::now()) > strtotime($timer->duedate)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function isLocked(){
        return false;
    }
    
    
}
