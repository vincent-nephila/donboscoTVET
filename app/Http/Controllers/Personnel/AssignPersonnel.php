<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

class AssignPersonnel extends Controller
{
    public function __construct(){
    	$this->middleware('auth',['except' => array('assignId')]);
    }

    function alllist(){
    	$personnels = \App\User::where('accesslevel',50)->get();

    	return view('teacher.list',compact('personnels'));
    }

    function view($idno){
    	$personnel = \App\User::where('idno',$idno)->first();
        //Active Batches
        $batches = \App\CtrSchoolYear::where('active',1)->get();

    	//Person's Roles
    	$positions = \App\UsersPosition::query()
    		->join('positions as p','p.position_id','=','users_positions.position_id')
    		->where('idno',$idno)->orderBy('p.position_id')->get(['*','users_positions.id as user_pos','users_positions.position_id as pos_id']);

    	$currentroles = $positions->pluck('pos_id')->toArray();
    	//Current Shops
    	$shops = \App\TvetCourse::get();

        //Assigned Sections
        $sections = \App\TvetSection::where('adviser_id',$idno)->whereIn('batch',$batches->pluck('period')->toArray())->get();
        
        //Assigned Sections
        $classes = \App\TvetClass::where('adviser',$idno)->whereIn('batch',$batches->pluck('period')->toArray())->get();

    	//All Roles
    	$roles = \App\Position::select('*')->whereNotIn('id',$currentroles)->where('position_id','!=',6)->where('department','TVET')->orderBy('position_id','ASC')->get();

    	return view('teacher.assign',compact('personnel','batches','positions','roles','currentroles','shops','sections','classes'));
    }

    function assignrole(Request $request){
        self::addRole($request);
    	return back();

    }
    
    static function addRole($position){
    	$assignRole = new \App\UsersPosition();
    	$assignRole->idno = $position['personnel'];
    	$assignRole->position_id = $position['position'];
    	$assignRole->save();
        
        return $position;
    }

    function unassignrole($id){
    	$unassignrole = \App\UsersPosition::find($id);

    	$this->removeRoles($unassignrole);

    	$unassignrole->delete();


    	return back();
    }

    function removeRoles($roles){
    	$role = $roles->position_id;
    	$idno = $roles->idno;

    	if($role == 5){
    		$shops = \App\TvetCourse::where('course_head',$idno)->get();
    		foreach($shops as $shop){
    			$this->assignHead($shop->id,"");
    		}
    	}
    	if($role == 4){
    		$sections = \App\TvetSection::where('adviser_id',$idno)->get();
    		foreach($sections as $section){
    			$this->assignAdviser($section->id,"");
    		}
    	}
    	if($role == 3){
    		$classes = \App\TvetClass::where('adviser',$idno)->get();
    		foreach($classes as $class){
    			$this->assignTeacher($class->id,"");
    		}
    	}
    	return null;
    }

    function assignId(Request $request){
    	$entryId = $request->id;
    	$personnel = $request->person;
    	$role = $request->crate;

    	if($role == 5){
    		$this->assignHead($entryId,$personnel);
    	}
    	if($role == 4){
    		self::assignAdviser($entryId,$personnel);
    	}
    	if($role == 3){
    		self::assignTeacher($entryId,$personnel);
    	}
    }

    function assignHead($shops,$idno){
    	$shop = \App\TvetCourse::find($shops);
    	$shop->course_head = $idno;
    	$shop->save();

    	return back();
    }

    static function assignAdviser($sections,$idno){
    	$section = \App\TvetSection::find($sections);
        if($section){
            $section->adviser_id = $idno;
            $section->save();
            return back();
        }else{
            return back()->withErrors(['warning'=>'Section do not exist']);
        }
    }

    static function assignTeacher($classes,$idno){
    	$class = \App\TvetClass::find($classes);
        if($class){
            $class->adviser = $idno;
            $class->save();

            return back();
        }else{
            return back()->withErrors(['warning'=>'Class do not exist']);
        }

    }
}
