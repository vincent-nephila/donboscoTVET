<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AddNewTeacher extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    function index(){
    	return view('teacher.addteacher');
    }

    function save(Request $request){
    	$teacher = new \App\User();
    	$teacher->idno = $request->idno;
    	$teacher->title = $request->title;
    	$teacher->lastname = $request->lastname;
    	$teacher->firstname = $request->firstname;
    	$teacher->middlename = $request->middlename;
    	$teacher->accesslevel = 50;
    	$teacher->gender = $request->gender;
    	$teacher->email = $request->email;
        $teacher->password = bcrypt($request->idno);
    	$teacher->save();

        return redirect(route('personnellist'));
    }

}
