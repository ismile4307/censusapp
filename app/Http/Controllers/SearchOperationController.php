<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\FilterParameter;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExport;

use DB;
use Auth;
use Str;

class SearchOperationController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('data_analysis.search_operation',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_all_parameter($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $table_info=DB::select('SELECT qid, question_text FROM questions_'.$project_code.' WHERE project_code='.$project_code.' AND qtype=1 AND show_in_filter=1 and status=1');

        $selected_parameter=DB::select('SELECT qid, question_text FROM filter_parameters WHERE project_id='.$id.' AND user_id='.Auth::User()->id);

        $all_value=array();
        array_push($all_value,$table_info);
        array_push($all_value,$selected_parameter);
        return $all_value;
    }

    public function save_filter_parameter(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $project_id=$request->input('project_id');
        $selected_parameter=$request->input('selected_parameter');

        // dd('DELETE FROM filter_parameters WHERE project_id='.$id.' AND user_id='.Auth::user()->id);  
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
        $qtext=DB::select('SELECT question_text FROM questions_'.$project_code.' WHERE project_code='.$project_code.' AND qid="'.$qid.'"');
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
        // dd($filter_parameters);
        return $filter_parameters;
    }

    private function get_attribute_list($id,$qid)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_results=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE project_code='.$project_code.' AND qid="'.$qid.'" ORDER BY attribute_order');
        return $db_results;

    }

    public function get_filter_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');
        // dd($filter_values);

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        $table_fields=DB::select('SELECT qid, qtype, question_text FROM questions_'.$project_code.' WHERE show_in_search=1 AND Status=1 ORDER BY qorder');

        $field_query="";
        $join_query="";

        $i=1;
        foreach($table_fields as $field){
            if($field->qtype=="1"){
                $field_query=$field_query.'a'.$i.'.attribute_label AS '.$field->qid.', ';
                $join_query=$join_query.'JOIN attributes_'.$project_code.' as a'.$i.' ON d1.'.$field->qid.'=a'.$i.'.attribute_value AND a'.$i.'.qid="'.$field->qid.'" ' ;
                $i++;
            }else if($field->qtype=="3" || $field->qtype=="4"){
                $field_query=$field_query.'d1.'.$field->qid.', ';
            }

        }

        

        $final_query='SELECT '.Str::substr($field_query,0,Str::length($field_query)-2).' FROM data_sr_'.$project_code.' as d1 '.$join_query;
        // dd($final_query);
        if($where!="")
            $db_results=DB::select($final_query.' WHERE '.$where.''); 
        else
            $db_results=DB::select($final_query); 
        //dd($db_results);

        $my_data=array();
        array_push($my_data,$db_results);
        array_push($my_data,$table_fields);
        // dd($my_data);
        return $my_data;
        
    }

    public function download_search_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        $table_fields=DB::select('SELECT qid, qtype, question_text FROM questions_'.$project_code.' WHERE show_in_search=1 AND Status=1 ORDER BY qorder');

        $field_query="";
        $join_query="";

        $i=1;
        foreach($table_fields as $field){
            if($field->qtype=="1"){
                $field_query=$field_query.'a'.$i.'.attribute_label AS '.$field->qid.', ';
                $join_query=$join_query.'JOIN attributes_'.$project_code.' as a'.$i.' ON d1.'.$field->qid.'=a'.$i.'.attribute_value AND a'.$i.'.qid="'.$field->qid.'" ' ;
                $i++;
            }else if($field->qtype=="3" || $field->qtype=="4"){
                if($field->qid=="RespondentId")
                    $field_query=$field_query.'CONCAT(" ", d1.'.$field->qid.') AS RespondentId, ';
                else
                    $field_query=$field_query.'d1.'.$field->qid.', ';
            }

        }

        

        $final_query='SELECT '.Str::substr($field_query,0,Str::length($field_query)-2).' FROM data_sr_'.$project_code.' as d1 '.$join_query;
        // dd($final_query);
        if($where!="")
        $myQuery=$final_query.' WHERE '.$where.''; 
        else
        $myQuery=$final_query; 
        //dd($db_results);

        // $myData=DB::select($myQuery);


        return Excel::download(new SearchExport($myQuery), $project->project_name.'_Search_Result.xlsx');
        //return Excel::download(new UsersExport, 'users-collection.xlsx');
        //return Excel::download(new RLDExport($data_array), $project_name.'_RLD_'.$st_date.'_'.$ed_date.'.xlsx');
    }
    
    private function get_where_syntax($filter_qids,$filter_values)
    {
        $where="";
        $i=0;
        foreach($filter_qids as $qid){
            if($filter_values[$i]!=0){
                if(count($filter_values[$i])>0){
                    $where_or="(";
                    foreach($filter_values[$i] as $values){
                        $where_or=$where_or.'d1.'.$qid.'="'.$values.'" OR ';
                    }
                    $where_or=Str::substr($where_or,0,Str::length($where_or)-4).")";
                    $where=$where.$where_or.' AND ';
                }
            }
            $i++;
        }

        if($where!="")
            $where=Str::substr($where,0,Str::length($where)-5);

        return $where;
    }
}

?>
