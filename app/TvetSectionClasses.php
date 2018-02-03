<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvetSectionClasses extends Model
{
    public function assignedClass(){
        return $this->belongsTo('\App\TvetClass','class_id');
    }
    
    public function TvetSection(){
        return $this->belongsTo('\App\TvetSection','section_id');
    }
    
}
