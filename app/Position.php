<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function UsersPosition(){
        return $this->hasMany('\App\UsersPosition','position_id','position_id');
    }
}
