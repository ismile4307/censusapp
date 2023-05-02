<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use DB;
use Auth;

class UserRoleController extends Controller
{
    public function index(){
        return view('admin.user_role');
    }

    public function get_user_data(){
        $all_users=DB::select('SELECT users.id, users.name, users.email, organizations.org_name, user_types.user_type 
        FROM users 
        INNER JOIN user_types ON users.user_type_id=user_types.id 
        INNER JOIN organizations ON users.organization_id=organizations.id 
        WHERE users.status=1 ORDER BY organizations.id');
        return $all_users;
    }

    public function get_user_role($user_id){
        $user_roles=DB::select('SELECT al.id, al.activity_id, al.activity, ua.activity_id as user_activity_id FROM activity_lists as al LEFT JOIN (SELECT * FROM user_activities WHERE user_id='.$user_id.') as ua on al.activity_id=ua.activity_id ORDER BY al.activity_id');
        // $all_roles=DB::select('SELECT * FROM activity_lists WHERE status=1');
        return $user_roles;
    }

    public function save_user_role(Request $request, $user_id){
        DB::delete('DELETE FROM user_activities where user_id='.$user_id);
        $selected_roles=$request->input('selected_roles');

        for($i=0;$i<count($selected_roles);$i++){
            DB::insert('INSERT INTO `user_activities`(`user_id`, `activity_id`, `statis`) VALUES ('.$user_id.','.$selected_roles[$i].',1)');
        }

        return true;
    }
}
