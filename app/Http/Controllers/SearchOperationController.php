<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\FilterParameter;
use DB;
use Auth;
use Str;

class SearchOperationController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        return view('data_analysis.search_operation',['project'=>$project]);
    }

    public function get_all_parameter($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $table_info=DB::select('SELECT qid, question_text FROM questions WHERE project_code='.$project_code.' AND qtype=1 AND show_in_filter=1 and status=1');

        return $table_info;
    }

    public function save_filter_parameter(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $project_id=$request->input('project_id');
        $selected_parameter=$request->input('selected_parameter');

        DB::delete('DELETE FROM filter_parameters WHERE project_id='.$id.' AND user_id='.Auth::user()->id);

        for($i=0;$i<count($selected_parameter);$i++){
            $filter_parameter=new FilterParameter();
            $filter_parameter->project_id=$project_id;
            $filter_parameter->user_id=Auth::User()->id;
            $filter_parameter->qid=$selected_parameter[$i];
            $filter_parameter->question_text=$this->get_qtext($project_code,$selected_parameter[$i]);

            $filter_parameter->save();
        }

        return response()->json(['success'=>'Data inserted successfully']);
    }

    private function get_qtext($project_code,$qid)
    {
        $qtext=DB::select('SELECT question_text FROM questions WHERE project_code='.$project_code.' AND qid="'.$qid.'"');
        return $qtext[0]->question_text;
    }

    public function get_filter_parameter($id)
    {
        $db_results=DB::select('SELECT qid, question_text FROM filter_parameters WHERE project_id='.$id.' AND user_id='.Auth::User()->id);

        $filter_qids=array();
        $filter_qtexts=array();
        $filter_attributes=array();
        $filter_parameters=array();

        foreach($db_results as $result){
            array_push($filter_qids,$result->qid);
            array_push($filter_qtexts,$result->question_text);
            array_push($filter_attributes,$this->get_attribute_list($id,$result->qid));
        }
        array_push($filter_parameters,$filter_qids);
        array_push($filter_parameters,$filter_attributes);
        array_push($filter_parameters,$filter_qtexts);
        return $filter_parameters;
    }

    private function get_attribute_list($id,$qid)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_results=DB::select('SELECT attribute_value, attribute_label FROM attributes WHERE project_code='.$project_code.' AND qid="'.$qid.'" ORDER BY attribute_order');
        return $db_results;

    }

    public function get_filter_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where="";
        $i=0;
        foreach($filter_qids as $qid){
            if($filter_values[$i]!=0){
                $where=$where.'d1.'.$qid.'="'.$filter_values[$i].'" AND ';
            }
            $i++;
        }
        $where=Str::substr($where,0,Str::length($where)-5);

        $db_results=DB::select('SELECT d1.id, 
        d1.RespondentId,	
        d1.Latitude, 
        d1.Longitude, 
        a1.attribute_label as Centre, 
        a2.attribute_label as Thana, 
        d1.Q3, 
        d1.StoreName, 
        d1.StoreAddress, 
        d1.RespName, 
        d1.RespMobile FROM data_sr_'.$project_code.' as d1 
        INNER JOIN attributes as a1 ON d1.Centre=a1.attribute_value 
        INNER JOIN attributes as a2 ON d1.Thana=a2.attribute_value 
        WHERE '.$where.' AND a1.qid="Centre" AND a2.qid="Thana"');
        
        
        return $db_results;


    }
    
}

?>
