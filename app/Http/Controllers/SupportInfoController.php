<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class SupportInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        if($id==1) $myLabel="User Type";
        else if ($id==2) $myLabel="Organizatoin";
        
        return view('settings.support_Info',['id'=>$id,'myLabel'=>$myLabel]);
    }

    public function get_support_info($id){

        $db_results='';
        if($id==1){
            $db_results=DB::select('SELECT id, user_type as info FROM user_types WHERE status=1');
        }else if ($id==2){
            $db_results=DB::select('SELECT id, org_name as info FROM organizations WHERE status=1');
        }
        return $db_results;
    }
}
