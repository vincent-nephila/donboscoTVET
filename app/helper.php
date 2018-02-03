<?php
    public static function getName($idno){
    	$name = "";

    	$users = \App\User::where('idno',$idno)->first();
    	if($users){
    		$name = $users->firstname." ".$users->lastname;
    	}
    	

    	return $name;
    }
?>