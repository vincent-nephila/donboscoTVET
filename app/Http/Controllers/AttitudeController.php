<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Reports\Helper as ReportHelp;
use App\Http\Controllers\GradeAccessControll as GradeAccess;

class AttitudeController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }
    //Jalopnik
    function viewAttitude($batch,$idno,$semester){
        $attitudes = \App\TvetAttitudeResult::with('TvetAttitude')->where('idno',$idno)->where('batch',$batch)->where('semester',$semester)->get();
        $studentSection = \App\Status::where('idno',$idno)->where('period',$batch)->first();
        
        $section = ReportHelp::studentSectionInfo($studentSection);
        
        if(ReportHelp::reportsViewable($section)){
            
            if(GradeAccess::reportEditable($section,"ATTITUDE",$semester)){
                return view('grades.editAttitude',compact('attitudes','batch','idno','section'));
            }else{
                $gradeAvailable = GradeAccess::section_gradeAvailable($section, "ATTITUDE", $semester);
                
                return view('grades.viewAttitude',compact('attitudes','batch','idno','gradeAvailable','section'));
            }
            
        }
        
    }
    
    function update_studentAttitude(Request $request){
        $rate = $request->rate;
        $attitude = $request->attitude;
        
        \App\TvetAttitudeResult::find($attitude)->update(["rating"=>$rate]);
    }
    
    function forwardAttitude(Request $request){
        $report = "ATTITUDE";
        return GradeAccess::updateReportsStat($request,$report);
    }
    
}
