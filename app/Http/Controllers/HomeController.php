<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;

use DB;
use Auth;
use Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->user_type_id==1){
            // $projects=Project::All()->where('status',1) ;
            $projects=DB::select('SELECT projects.`id`, projects.`project_name`, projects.`project_code`, projects.`project_type`, projects.`start_date`, projects.`end_date`, projects.`sample_size`, projects.operated_by, projects.class_name FROM `projects` 
            WHERE projects.status=1
            ORDER BY projects.id');
            return view('home',['projects'=>$projects]);
        }else if(Auth::user()->user_type_id==2){
            // || Auth::user()->user_type_id==3
            // $projects=Project::All()->where('status',1)->where('organization_id',Auth::user()->organization_id) ;
            $projects=DB::select('SELECT projects.`id`, projects.`project_name`, projects.`project_code`, projects.`project_type`, projects.`start_date`, projects.`end_date`, projects.`sample_size`, projects.operated_by, projects.class_name FROM `projects` 
            WHERE projects.status=1 AND projects.organization_id='.Auth::user()->organization_id.' 
            ORDER BY projects.id');
            return view('home',['projects'=>$projects]);
        }else if(Auth::user()->user_type_id>=3){
            $projects=DB::select('SELECT projects.`id`, projects.`project_name`, projects.`project_code`, projects.`project_type`, projects.`start_date`, projects.`end_date`, projects.`sample_size`, projects.operated_by, projects.class_name FROM `projects` 
            INNER JOIN project_users ON projects.id=project_users.project_id 
            WHERE projects.status=1 AND project_users.status=1 AND project_users.user_id='.Auth::user()->id.' 
            ORDER BY projects.id;');
            return view('home',['projects'=>$projects]);
        }else{
            return view('auth.login');
        }

        //return view('home');
    }

    public function project_info($id)
    {
        $project=Project::find($id);  
        
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('project_info',['project'=>$project,'activity'=>$user_activity]);
    }
}

?>
