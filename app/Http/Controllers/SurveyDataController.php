<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveyDataExport;

use DB;
use Auth;
use Str;
use DateTime;

class SurveyDataController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('data_analysis.survey_data',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_filter_parameter($id)
    {
        $db_results=DB::select('SELECT qid, question_text FROM survey_filters WHERE project_id='.$id);

        $filter_qids=array();
        $filter_qtexts=array();
        $filter_attributes=array();
        $filter_parameters=array();

        // array_push($filter_qids,'MyFltr');
        // array_push($filter_qtexts,'Interivew View');
        // array_push($filter_attributes,[]);

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

    public function get_survey_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        if($where!="")
            $where=' AND '.$where;
        $contact_type=$request->input('contactType');
    
        $db_results=[];
        if($contact_type==2){
            $db_results=DB::select('SELECT d1.id, 
            CONVERT(d1.RespondentId,CHAR) as RespondentId, 
            d1.RespName,	
            d1.RespMobile, 
            sl.survey_link FROM data_sr_'.$project_code.' as d1 
            INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
            WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where);
        }else{
            $db_results=DB::select('SELECT d1.id, 
            CONVERT(d1.RespondentId,CHAR) as RespondentId, 
            d1.RespName,	
            d1.RespMobile, 
            sl.survey_link FROM data_sr_'.$project_code.' as d1 
            INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
            WHERE sl.status='.$contact_type.$where);
        }
        return $db_results;
    }

    public function update_data_status(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $survey_link=$request->input('myLink');
        $contact_type=$request->input('contactType');

        $db_results=DB::select('SELECT * FROM `survey_links_'.$project_code.'` WHERE `survey_link`="'.$survey_link.'" AND `status`='.$contact_type.'');

        $return_value=[];
        if($db_results==[]){
            array_push($return_value,"1");
            array_push($return_value,$db_results);
            return $return_value;
        }
        
        date_default_timezone_set('Asia/Dhaka');
        $myDateTime=(string)Carbon::now();

        DB::update('UPDATE `survey_links_'.$project_code.'` SET `interviewed_by`='.Auth::user()->id.',`interview_date`="'.$myDateTime.'",`status`=9 WHERE `survey_link`="'.$survey_link.'"');

        $db_results=$this->get_survey_data($request, $id);

        array_push($return_value,"2");
        array_push($return_value,$db_results);
        return $return_value;
    }

    public function update_survey_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $survey_link=$request->input('myLink');
        $calling_status=$request->input('calling_status');
        $respondent_id=$request->input('respondent_id');

        
        date_default_timezone_set('Asia/Dhaka');
        $myDateTime=(string)Carbon::now();

        DB::update('UPDATE `survey_links_'.$project_code.'` SET `interviewed_by`='.Auth::user()->id.',`interview_date`="'.$myDateTime.'",`status`='.$calling_status.' WHERE `survey_link`="'.$survey_link.'"');
        DB::insert('INSERT INTO `call_status`(`project_code`, `respondent_id`, `interviewed_by`, `interview_date`, `status`) 
                    VALUES ('.$project_code.','.$respondent_id.','.Auth::user()->id.',"'.$myDateTime.'",'.$calling_status.')');
        
        return 1;
    }

    private function get_where_syntax($filter_qids,$filter_values)
    {
        $where="";
        $i=0;
        foreach($filter_qids as $qid){
            if($filter_values[$i]!=0){
                // if(count($filter_values[$i])>0){
                //     $where_or="(";
                //     foreach($filter_values[$i] as $values){
                //         $where_or=$where_or.'d1.'.$qid.'="'.$values.'" OR ';
                //     }
                //     $where_or=Str::substr($where_or,0,Str::length($where_or)-4).")";
                //     $where=$where.$where_or.' AND ';
                // }


                $where=$where.'d1.'.$qid.'="'.$filter_values[$i].'"'.' AND ';
            }
            $i++;
        }

        if($where!="")
            $where=Str::substr($where,0,Str::length($where)-5);

        return $where;
    }

    public function cati_report(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');

        
        $db_results=DB::select('SELECT users.name AS "InterviewerName", SUM(CASE WHEN sl.status=3 THEN 1 ELSE 0 END) as "CompleteInterview",
                    SUM(CASE WHEN sl.status=2 THEN 1 ELSE 0 END) as "IncompleteInterview",
                    SUM(CASE WHEN sl.status=4 THEN 1 ELSE 0 END) as "RingingnotReceived",
                    SUM(CASE WHEN sl.status=5 THEN 1 ELSE 0 END) as "SwitchedOff",
                    SUM(CASE WHEN sl.status=6 THEN 1 ELSE 0 END) as "InvalidNumber"
                FROM survey_links_23002 AS sl
                INNER join users on sl.interviewed_by=users.id Where sl.interviewed_by>0
                GROUP BY users.name');
        
        return $db_results;
    }

    public function export_survey_data(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        if($where!="")
            $where=' AND '.$where;
        $contact_type=$request->input('contactType');
    
        $myQuery='';
        if($contact_type==2){
            $myQuery='SELECT d1.id,  
            CONCAT(" ",d1.RespondentId) as RespondentId, 
            d1.RespName,	
            d1.RespMobile, 
            sl.survey_link FROM data_sr_'.$project_code.' as d1 
            INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
            WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where;
        }else{
            $myQuery='SELECT d1.id,  
            CONCAT(" ",d1.RespondentId) as RespondentId, 
            d1.RespName,	
            d1.RespMobile, 
            sl.survey_link FROM data_sr_'.$project_code.' as d1 
            INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
            WHERE sl.status='.$contact_type.$where;
        }
        //return $db_results;

        return Excel::download(new SurveyDataExport($myQuery), $project->project_name.'_Search_Result.xlsx');

    }
}

?>
