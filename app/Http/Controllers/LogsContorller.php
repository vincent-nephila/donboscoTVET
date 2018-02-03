<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LogsContorller
{
    static function createSystemLog($action,$message){
        $log = new \App\Log();
        $log->action = $action;
        $log->message = $message;
        $log->user = \Auth::user()->idno;
        $log->save();
        
    }
}
