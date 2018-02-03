<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    
    public function courseCode(){
        return \App\TvetCourse::where('course',$this->course)->first()->course_id;
    }
}
