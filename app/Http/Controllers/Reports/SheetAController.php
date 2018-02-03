<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\ClassManagement\SectionController;
use App\Http\Controllers\Reports\Helper as Fetcher;
use App\Http\Controllers\GradeAccessControll as GradeAccess;
class SheetAController extends Controller
{
    public function __construct() {
        $this->middleware('auth',['except' => array('assignId','viewSubjectGrades','viewSubjectInfo','forwardSectionSubject')]);
    }
    
    function sheetAList($batch){
        $courses = \App\TvetCourse::get();
        $sections = \App\TvetSection::where('batch',$batch)->orderBy('section')->get();
        
        return view('gradereports.sheetalist',compact('courses','sections','batch'));
    }
    
    function sheetAView($id){
        $section =  \App\TvetSection::find($id);
        $students = SectionController::sectionStudents($section);
        $subjects = \App\TvetSubjects::where('course_id',$section->course_id)->orderBy('category')->orderBy('sort')->get()->groupBy('sem');
        if(Fetcher::reportsViewable($section)){
            return view('gradereports.sectionSheetA',compact('section','students','subjects'));
        }else{
            return back()->withErrors(['warning'=>'You are trying to access / change data that is unavailable to you.']);
        }
    }
    
    
    //------------------------This part is only for ajax------------------------//
    
    function viewSubjectGrades(){
        $subject = Input::get('subject');
        $section_id = Input::get('id');
        
        $section =  \App\TvetSection::find($section_id);
        $students = SectionController::sectionStudents($section);
        
        $class = \App\TvetClass::find($section->tvet_section_classes->pluck('class_id')->toArray())->where('subject',$subject)->where('submissionLocked',1);
        
        if(count($class)>0 && GradeAccess::reportEditable($section,$subject)){
            $field = "section_changeGrade";
            return view('ajax.sectionsheet',compact('field','subject','section','students'))->render();
        }else{
            $field = "student_list";
            return view('ajax.sectionsheet',compact('field','subject','section','students'))->render();
        }
        
        
    }
    
    function viewSubjectInfo(){
        $subject = Input::get('subject');
        $section_id = Input::get('id');
        $section =  \App\TvetSection::find($section_id);
        $classes = \App\TvetGrade::whereIn('idno',SectionController::sectionStudents($section)->pluck('idno')->toArray())->where('batch',$section->batch)->where('subject_code',$subject)->groupBy('section')->get();
        $field = "list_info";
        
        return view('ajax.sectionsheet',compact('field','subject','section','classes'))->render();
    }
    
    function forwardSectionSubject(Request $request){        
        $report = $request->subject;
        return GradeAccess::updateReportsStat($request,$report);
    }
    
    public static function inputGrade($subject,$batch,$idno){
        $record = \App\TvetGrade::where('subject_code',$subject)->where('idno',$idno)->where('batch',$batch)->first();
        if($record){
            return "<input class='form-control student' min='70' max='100' type='number' id='$record->id' value='$record->grade'>";
        }else{
            return "Cant retrieve record";
        }
    }
}
