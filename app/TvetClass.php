<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvetClass extends Model
{
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    protected  $fillable = ['submissionLocked','viewUpTo','adviser'];
    
    public function tvet_section_classes(){
        return $this->hasOne('\App\TvetSectionClasses','class_id');
    }
}
