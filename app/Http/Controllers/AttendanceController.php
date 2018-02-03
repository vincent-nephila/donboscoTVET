<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Reports\Helper as ReportHelp;
use App\Http\Controllers\ClassManagement\SectionController;
use App\Http\Controllers\GradeAccessControll as GradeAccess;

class AttendanceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function viewStudentAttendance($sectionid,$semester){
        $section = \App\TvetSection::find($sectionid);
        if(ReportHelp::reportsViewable($section)){
            
            $students= SectionController::sectionStudents($section);
            $schooldays = \App\TvetSchoolDays::where('sem',$semester)->where('batch',$section->batch)->where('course_id',$section->course_id)->get();
            
                    
            if(GradeAccess::reportEditable($section,"ATTENDANCE",$semester)){
                return view('grades.editAttendance',compact('section','students','schooldays','semester'));
                
            }else{
                $gradeAvailable = GradeAccess::section_gradeAvailable($section, "ATTENDANCE", $semester);
                
                return view('grades.viewAttendance',compact('section','students','schooldays','semester','gradeAvailable'));
            }
            
        }
    }
    
    function updateStudentAttendance(Request $request){
        $batch    = $request->batch;
        $student  = $request->student;
        $semester = $request->semester;
        $type     = $request->type;
        $month    = $request->month;
        $grade    = $request->grade;
        $order    = 0;
        $name     = "";
        
       $attendance = \App\TvetAttendance::where('batch',$batch)->where('idno',$student)->where('sem',$semester)->where('type',$type)->first();
       if($attendance){
        $attendance->$month = $grade;
        $attendance->save();
       }else{
           $this->createAttendance($request);
       }
    }
    
    function createAttendance($request){
        $month = $request['month'];
       switch($request['type']){
           case 'DAYP':
               $order = 1;
               $name = "Days Present";
               break;
           case 'DAYA':
               $order = 2;
               $name = "Days Absent";
               break;
           case 'DAYT':
               $order = 3;
               $name = "Days Tardy";
               break;
       }
       $newAttendance = new \App\TvetAttendance();
       $newAttendance->batch = $request['batch'];
       $newAttendance->idno = $request['student'];
       $newAttendance->sem = $request['semester'];
       $newAttendance->order = $order;
       $newAttendance->name = $name;
       $newAttendance->type = $request['type'];
       $newAttendance->$month = $request['grade'];
       $newAttendance->save();
    }
    
    function forwardAttendance(Request $request){
        $report = "ATTENDANCE";

        return GradeAccess::updateReportsStat($request,$report);
    }
    
    
}
