<?php

namespace App\Http\Controllers\Settings;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\MyClass;

use DB;

class ProjectUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view ('projects.project_users',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_project_info($id)
    {
        
        $project_info=DB::select('SELECT id, project_name, project_code FROM projects WHERE id ='.$id.';');//, [$id]);
        // $project_info=Project::All();
        return $project_info;
    }

    public function get_users($id)
    {
        
        // $all_Interviewers=Interviewer::All()->where('status',1);
        
        // $all_Users=DB::select('select * from interviewers where status=1 and interviewers.id NOT IN (SELECT interviewer_id FROM project_interviewers WHERE project_id='.$id.')');
        
        $all_Users=DB::select('SELECT users.id, users.name, user_types.user_type, organizations.org_name as organization_name FROM users 
        INNER JOIN user_types ON users.user_type_id=user_types.id 
        INNER JOIN organizations ON users.organization_id=organizations.id 
        WHERE users.status=1 AND users.user_type_id>2 AND users.id NOT IN (SELECT user_id FROM project_users WHERE project_id='.$id.');');

        return $all_Users;
    }


    public function get_project_user_info($id)
    {
        
        $project_user_info=DB::select('SELECT project_users.id, users.name, user_types.user_type, organizations.org_name as organization_name FROM users 
        INNER JOIN project_users ON users.id=project_users.user_id 
        INNER JOIN user_types ON users.user_type_id=user_types.id 
        INNER JOIN organizations ON users.organization_id=organizations.id  
        WHERE project_users.project_id ='.$id.';');//, [$id]);
        // $project_info=Project::All();
        return $project_user_info;
    }

    public function assign_users(Request $request)
    {
        $projectId=$request->input('project_id');
        $selectedUsers=$request->input('selectedUsers');

        //return $selectedUsers;

        for($i=0;$i<count($selectedUsers);$i++){
            $projectUser=new ProjectUser();
            $projectUser->project_id=$projectId;
            $projectUser->user_id=$selectedUsers[$i];
            $projectUser->status=1;

            $projectUser->save();
        }

        return response()->json(['success'=>'Data inserted successfully']);
    }

    public function delete_project_user($id)
    {
        $projectUser=ProjectUser::find($id);
        $projectUser->delete();

        return response()->json(['success'=>'Data deleted successfully']);
    }
}
