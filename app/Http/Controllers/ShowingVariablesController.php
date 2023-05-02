<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;

use DB;
use Auth;
use Str;
class ShowingVariablesController extends Controller
{
    public function index($id){
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('settings.showing_variables',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_table_data($id){
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE show_in_search=1');
        return $db_result;
    }

    public function get_variable_list($id){
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE show_in_search=0');
        return $db_result;
    }

    public function set_variable_list(Request $request,$id){
        $varList=$request->input('varList');
        $project=Project::find($id);
        $project_code=$project->project_code;

        
        for($i=0;$i<count($varList);$i++)
        {
            DB::update('UPDATE questions_'.$project_code.' SET show_in_search = 1 WHERE id = ?', [$varList[$i]]);
        }

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE show_in_search=1');
        return $db_result;
    }

    public function remove_variable($id,$qid){
        $project=Project::find($id);
        $project_code=$project->project_code;
        DB::update('UPDATE questions_'.$project_code.' SET show_in_search = 0 WHERE id = ?', [$qid]);

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE show_in_search=1');
        return $db_result;
    }
}
