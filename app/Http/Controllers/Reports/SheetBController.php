<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClassManagement\SectionController;
use App\Http\Controllers\GradeAccessControll as GradeAccess;

class SheetBController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function sheetBView($id){
        $section = \App\TvetSection::find($id);
        $students = SectionController::sectionStudents($section);
        $subjects = \App\TvetSubjects::where('course_id',$section->course_id)->orderBy('category')->orderBy('sort')->get()->groupBy('sem');
        
        
        
        return view('gradereports.sectionSheetB',compact('section','students','subjects'));
        
    }
}
