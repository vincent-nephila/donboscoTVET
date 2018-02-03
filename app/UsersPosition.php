<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPosition extends Model
{
    public function Position(){
        return $this->belongsTo('App\Position','position_id','position_id');
    }
    
    public function User(){
        return $this->belongsTo('App\User','idno','idno');
    }
}
