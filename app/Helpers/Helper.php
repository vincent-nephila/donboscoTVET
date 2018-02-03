<?php

namespace App\Helpers;

class Helper {

    public static function getName($idno){
    	$name = "";

    	$users = \App\User::where('idno',$idno)->first();
    	if($users){
    		$name = $users->title." ".$users->firstname." ".$users->lastname;
    	}
    	

    	return $name;
    }
    
    public static function getprofilePic($idno){
        $image = 'images/no_pic.png';
        
        $user = \App\User::where('idno',$idno)->first();
        if($user && ($user->profile_picture != "")){
            $image = 'images/'.$user->profile_picture;
        }
        
        return $image;
    }

    public static function getNameReverse($idno){
        $name = "";

        $users = \App\User::where('idno',$idno)->first();
        if($users){
            $name = trim($users->lastname).", ".trim($users->firstname);
        }
        

        return $name;
    }

    public static function subjectName($subject_id){
    	$name = "";

    	$subject = \App\TvetSubjects::where('subject_code',$subject_id)->first();

    	if($subject){
    		$name = $subject->subject_name;
    	}

    	return $name;
    }

    public static function className($getclass,$field){
        $name = "";
        if($getclass){
            $class = \App\TvetClass::find($getclass->$field);

            if($class){
                $name = $class->section;
            }
        }

        return $name;
    }

    public static function classAdviser($getclass,$field){
        $adviser = "";

        if($getclass){
            $class = \App\TvetClass::find($getclass->$field);

            if($class){
                $adviser = Helper::getName($class->adviser);
            }
        }

        return $adviser;
    }

    public static function classAdviserId($getclass,$field){
        $id = "";

        if($getclass){
            $class = \App\TvetClass::find($getclass->$field);

            if($class){
                $id = $class->adviser;
            }
        }

        return $id;
    }
    public static function resetSessionVar($var,$val){
        session()->forget($var);
        session()->put($var,$val);
    }
    
    public static function getPosition($position_id){
        $position = "";
        
        $pos = \App\Position::where('position_id',$position_id)->first();
        
        if($pos){
            $position = $pos->position;
        }
        if($position_id > 6){
            $position = "Registrar";
        }
        return $position;
    }
    
    public static function getSection($idno,$batch){
        return \App\Status::where('idno',$idno)->where('period',$batch)->first()->section;
    }
    
    public static function section_currentyIn($status,$section){
        switch($status){
            case 4:
                return $section->adviser_id;
            case 5:
                return \App\TvetCourse::where('course_id',$section->course_id)->first()->course_head;
            case 6:
                return \App\UsersPosition::where('position_id',6)->get()->implode('idno',";");
        }
    }
    
    public static function section_currentyInPosition($sectionId,$report,$semester = 0){
        $section = \App\TvetSection::find($sectionId);
        $status = \App\Http\Controllers\GradeAccessControll::reportStatus($section,$report,$semester);
    }
    
    public static function showSubmitButton($section,$report,$semester){
        $status = \App\Http\Controllers\GradeAccessControll::reportStatus($section, $report,$semester);
        
        $users = explode(";", \Helper::section_currentyIn($status->currentlyIn,$section));
        
        
        if(in_array(\Auth::user()->idno,$users)){
            return true;
        }else{
            return false;
        }
    }
            
            
    //Special helper for attendance
    
    public static function editstudentAttendance($batch,$idno,$semester,$type,$month){
        $attendance = \App\TvetAttendance::where('batch',$batch)->where('idno',$idno)->where('sem',$semester)->where('type',$type)->first();
        
        if($attendance){
            return "<input style='text-align:center' type='text' class='form-control attendance' value='".$attendance->$month."' data-student = '$idno' data-month = '$month' data-type = '$type'>";
        }else{
            return "<input style='text-align:center' type='text' class='form-control attendance' data-student = '$idno' data-month = '$month' data-type = '$type'>";
        }
    }
    
    public static function viewstudentAttendance($batch,$idno,$semester,$type,$month){
        $attendance = \App\TvetAttendance::where('batch',$batch)->where('idno',$idno)->where('sem',$semester)->where('type',$type)->first();
        
        
        
        
        if($attendance){
            return $attendance->$month;
        }else{
            return "";
        }
    }
    
    //Special helper for attendance END//
    
    
    public static function dropdownOption($curr_Selected,$type){
        $options = \App\CtrOption::where('type', $type)->get();
        $toView = "";
        
        foreach($options as $option){
            $toView = $toView."<option value='' hidden='hidden'></hidden>";
            $toView = $toView."<option value='".$option->value."'";
            if($option->value == $curr_Selected){
                $toView = $toView." selected = 'selected'";
            }
            $toView = $toView.">".$option->name."</opiton>";
        }
        
        return $toView;
    }
    
    
    static function debug_to_console( $data ) {
        if ( is_array( $data ) )
          $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
          $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }
    
}