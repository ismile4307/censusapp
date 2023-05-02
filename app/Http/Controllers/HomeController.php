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
        return view('home');
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
