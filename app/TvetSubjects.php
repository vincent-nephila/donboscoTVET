<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvetSubjects extends Model
{
	public function tvetCourse(){
		return $this->belongsTo('\App\TvetCourse','course_id','course_id');
	}
}
