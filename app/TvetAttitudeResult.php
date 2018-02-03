<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvetAttitudeResult extends Model
{
    protected  $fillable = ['attitude_id','idno','batch','semester','rating'];
    
    function TvetAttitude(){
        return $this->belongsTo('\App\TvetAttitude','attitude_id');
    }
}
