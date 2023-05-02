<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\SurveyFilter;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExport;

use DB;
use Auth;
use Str;

class SurveyFiltersController extends Controller
{
    public function index($id){
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('settings.survey_filters',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_table_data($id){
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result=DB::select('SELECT id, qid, question_text FROM survey_filters WHERE project_id='.$id);
        return $db_result;
    }

    public function get_variable_list($id){
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE qid NOT IN (SELECT qid FROM survey_filters WHERE project_id='.$id.')');
        return $db_result;
    }

    public function set_variable_list(Request $request,$id){
        $varList=$request->input('varList');
        $project=Project::find($id);
        $project_code=$project->project_code;
        
        // for($i=0;$i<count($varList);$i++)
        // {
        //     DB::update('UPDATE questions_'.$project_code.' SET show_in_filter = 1 WHERE id = ?', [$varList[$i]]);
        // }
        
        for($i=0;$i<count($varList);$i++)
        {
            $survey_filter=new SurveyFilter();
            $survey_filter->project_id=$id;
            $survey_filter->user_id=Auth::User()->id;
            $survey_filter->qid=$varList[$i];
            $survey_filter->question_text=$this->get_qtext($project_code,$varList[$i]);

            $survey_filter->save();
        }

        $db_result=DB::select('SELECT id, qid, question_text FROM questions_'.$project_code.' WHERE show_in_filter=1');
        return $db_result;
    }

    private function get_qtext($project_code,$qid)
    {
        $qtext=DB::select('SELECT question_text FROM questions_'.$project_code.' WHERE project_code='.$project_code.' AND qid="'.$qid.'"');
        return $qtext[0]->question_text;
    }

    public function remove_variable($id,$qid){
        $project=Project::find($id);
        $project_code=$project->project_code;

        DB::delete('DELETE FROM survey_filters WHERE project_id='.$id.' AND id="'.$qid.'"');

        $db_result=DB::select('SELECT id, qid, question_text FROM survey_filters WHERE project_id='.$id);
        return $db_result;
    }
}
