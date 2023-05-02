<?php

namespace App\Classes;

use DB;
use Auth;
use Str;

class MyClass {

    public function get_user_role(){
        $activity_lists=DB::select('SELECT * FROM activity_lists WHERE status=1 ORDER BY activity_id');

        $query="SELECT ";
        foreach($activity_lists as $activity){
            $query=$query.'SUM(CASE WHEN activity_id='.$activity->activity_id.' THEN 1 ELSE 0 END) as A'.$activity->activity_id.', ';
        }
        
        $query=Str::substr($query,0,Str::length($query)-2).' FROM user_activities WHERE user_id='.Auth::user()->id.';';
        
        $user_activities=DB::select($query);
        $user_activity=$user_activities[0];
        
        return $user_activity;
    }
}