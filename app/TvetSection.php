<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvetSection extends Model
{
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    protected  $fillable = ['adviser_id'];

    public function tvetCourse(){
            return $this->belongsTo('\App\TvetCourse','course_id','course_id');
    }
    
    public function tvet_section_classes(){
        return $this->hasMany('\App\TvetSectionClasses','section_id');
    }
}
