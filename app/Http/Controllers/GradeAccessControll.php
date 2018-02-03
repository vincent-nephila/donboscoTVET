<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class GradeAccessControll extends Controller
{
    public function __construct() {
     $this->middleware(['auth']);
    }
    
    public static function reportEditable($section,$report,$semester=0){
        $status = self::reportStatus($section, $report,$semester);
        $users = explode(";", \Helper::section_currentyIn($status->currentlyIn,$section));
        
        if(in_array(\Auth::user()->idno,$users) && self::user_verifyModifyAccess($status)){
            return true;
        }else{
            return false;
        }
    }
    
    public static function reportStatus($section,$report,$semester){
        
        $status =  \App\TvetGradeStatus::where('section_id',$section->id)->where('report',$report)->where('semester',$semester)->first();
        
        if(!$status){
            $status = self::createReporStat($section,$report,$semester);
        }
        
        return $status;
    }
    
    public static function createReporStat($section,$report,$semester){
            $status = new \App\TvetGradeStatus;
            $status->section_id = $section->id;
            $status->report = $report;
            $status->currentlyIn = 4;
            $status->semester = $semester;
            $status->save();
            
            return $status;
    }
    
    public static function updateReportsStat($request,$report){
        $sectionid = $request->section;
        $semester = $request->semester;
        
        $section = \App\TvetSection::find($sectionid);
        $status = self::reportStatus($section, $report,$semester);
        $to = $status->currentlyIn + 1;
        
        //LogsContorller::createSystemLog('info',$report.' forwarded for '.$section->section.', semester'.$semester);
        
        $users = explode(";", \Helper::section_currentyIn($status->currentlyIn,$section));
        if(in_array(\Auth::user()->idno,$users)){
            $status->currentlyIn = $to;
            $status->save();
            return back();
        }else{
            return back()->withErrors(['warning'=>'Currently not accessible to your account.']);
        }

    }
    
    public static function user_verifyModifyAccess($status){
        $module = "gradeModification";
        $access = \App\PositionAccess::where('position_id',$status->currentlyIn)->where('module_id',$module)->first();
        if(($access && ($access->status == 1)) || (($status->currentlyIn == 4) && in_array($status->report,array('ATTENDANCE','ATTITUDE')))){
            return true;
        }else{
            return false;
        }
    }
    
    public static function section_gradeAvailable($section,$report,$semester = 0){
        $status = self::reportStatus($section,$report,$semester);
        
        $users = "";
        $currentlyIn = $status->currentlyIn;
        
        while($currentlyIn > 3){
            $users = $users.\Helper::section_currentyIn($currentlyIn,$section).";";
            $currentlyIn--;
            
        }
        
        $usersList = explode(";",$users);
        
        if(in_array(\Auth::user()->idno,$usersList)){
            return true;
        }else{
            return false;
        }
    }
}
