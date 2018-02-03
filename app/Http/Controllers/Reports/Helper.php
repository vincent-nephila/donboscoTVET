<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GradeAccessControll as GradeControl;

class Helper extends Controller
{
    public static function getGrade($idno,$subjectcode,$section){
        //TODO: Create a checker if the grade is now available for user -------Done
        $grade = "";
        $record = \App\TvetGrade::where('idno',$idno)->where('subject_code',$subjectcode)->where('batch',$section->batch)->first();
        
        if($record && self::isGradeViewable($record,$subjectcode,$section)){
            $grade = $record->grade;
        }
        
        return $grade;
        
    }
    
    public static function computeSemFinal($idno,$sem,$batch){
        $final = "";
        
        $records = \App\TvetGrade::where("idno",$idno)->where('sem',$sem)->where('batch',$batch)->get();
        
        if($records->sum('percentage') != 100){
            return '<i data-toggle="tooltip" class="fa text-red fa-exclamation-circle" aria-hidden="true" title="Cannot compute total average. Percentage is greater / less than 100%. Please check the subject breakdown."></i>';
            
        }
        
        $missing = $records->where('grade',"");
        
        if(count($missing)>0){
            return "";
        }
        //TODO: Create a checker if the grade is now available for user
        
        //If all conditions are met compute the final grade
        if($records){
            $final = 0;
            foreach ($records as $record){
                $final = $final + ($record->grade * ($record->percentage/100));
            }
            return $final;
        }        
    }
    
    public static function isFinalGradeViewable($records){
        foreach($records as $record){
            $viewable = self::isGradeViewable($record);
            if(!$viewable){
                return false;
            }
        }
        
        return true;
    }
    
    public static function isGradeViewable($record,$subjectcode,$section){        
        $class = \App\TvetClass::where('section',$record->section)->where('batch',$record->batch)->where('subject',$record->subject_code)->first();
        
        if($class->submissionLocked == 1 && GradeControl::section_gradeAvailable($section,$subjectcode)){
            return true;
        }
        return false;
    }
    
    public static function reportsViewable($section){
        $user_id = \Auth::user()->idno;
        if($section->adviser_id == $user_id){
            return true;
        }
        
        $course = \App\TvetCourse::where('course_id',$section->course_id)->first();
        if($course && $course->course_head == $user_id){
            return true;
        }
        
        $role = \App\UsersPosition::where('idno',$user_id)->first();
        if($role && $role->position_id == 6){
            return true;
        }
        
        return false;
    }
    
    
    //Really really bad coding......pease replace if possible -Vincent
    //Finaly, a short code but still needs architectural overhaul
    public static function subject_submitToButton($subject,$section,$class){
        $classes = \App\TvetClass::whereIn('section',$class->pluck('section')->toArray())->where('batch',$section->batch)->where('subject',$subject)->get();
        $classStat = $classes->pluck('submissionLocked')->toArray();
        
        if(in_array(0,$classStat)){
            return (object) array('status'=>false,2);
        }else{
            $reportStat = GradeControl::reportStatus($section, $subject,0);
            
            if(\Helper::showSubmitButton($section,$subject,0)){
                return (object) array('status'=>true,'passto'=>\Helper::getPosition($reportStat->currentlyIn+1));
            }else{
                return (object) array('status'=>false,2);
            }
        }
    }
    
    public static function getFieldGrade($idno,$subjectcode,$section){
     return "none";   
    }
    
    public static function studentTotalAttendace($idno,$semester,$attendanceType,$batch){
        $attendance = \App\TvetAttendance::where('idno',$idno)->where('sem',$semester)->where('type',$attendanceType)->where('batch',$batch)->first();
        
        if($attendance){
            return $attendance->jan+$attendance->feb+$attendance->mar+$attendance->apr+$attendance->may+$attendance->jun+$attendance->jul+$attendance->aug+$attendance->sep+$attendance->oct+$attendance->nov+$attendance->dec;
        }else{
            return 0;
        }
        
    }
    
    static function studentSectionInfo($status){
        $course = \App\TvetCourse::where('course',$status->course)->first();
        return \App\TvetSection::where('section',$status->section)->where('batch',$status->period)->where('course_id',$course->course_id)->first();
    }
}
