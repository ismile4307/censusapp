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
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('data_analysis.survey_data',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_filter_parameter($id)
    {
        $project=Project::find($id);
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
        array_push($filter_parameters,$project);
        // dd($filter_parameters);
        return $filter_parameters;
    }

    private function get_attribute_list($id,$qid)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_results=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="'.$qid.'" ORDER BY attribute_order');
        return $db_results;

    }

    public function get_survey_data(Request $request, $id)
    {
        $my_query=$this->get_survey_data_query($request,$id);
        $db_results=DB::select($my_query);

        $my_count_query=$this->get_survey_data_count_query($request,$id);
        $db_count_results=DB::select($my_count_query);
        // dd($db_count_results);
        return [$db_results,$db_count_results];
    }

    private function get_survey_data_query($request, $id){
        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        if($where!="")
            $where=' AND '.$where;
        $contact_type=$request->input('contactType');
    
        $my_query=[];
        if($project_code=="23903"){
            if($contact_type==2){
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                a1.attribute_label as PanelBrand, 
                d1.MtoPoint, 
                sl.survey_link FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where.' ORDER BY RAND() LIMIT 50';
            }else{
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                a1.attribute_label as PanelBrand, 
                d1.MtoPoint, 
                sl.survey_link FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.$where.' ORDER BY RAND() LIMIT 50';
            }
        }elseif($project_code=="23902"){
            if($contact_type==2){
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                d1.ShopName, 
                d1.MtoPoint, 
                sl.survey_link FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where.' ORDER BY RAND() LIMIT 50';
            }else{
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                d1.ShopName, 
                d1.MtoPoint, 
                sl.survey_link FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.$where.' ORDER BY RAND() LIMIT 50';
            }
        }
        return $my_query;
    }

    private function get_survey_data_count_query($request, $id){
        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        if($where!="")
            $where=' AND '.$where;
        $contact_type=$request->input('contactType');
    
        $my_query=[];
        if($project_code=="23903"){
            if($contact_type==2){
                $my_query='SELECT count(d1.id) as Total
                FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where;
            }else{
                $my_query='SELECT count(d1.id) as Total
                FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.$where;
            }
        }elseif($project_code=="23902"){
            if($contact_type==2){
                $my_query='SELECT Count(d1.id) AS Total
                FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where;
            }else{
                $my_query='SELECT Count(d1.id) AS Total
                FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.$where;
            }
        }
        return $my_query;
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

        // $db_results=$this->get_survey_data($request, $id);


        $my_query=$this->get_survey_data_query($request,$id);
        $db_results=DB::select($my_query);

        $my_count_query=$this->get_survey_data_count_query($request,$id);
        $db_count_results=DB::select($my_count_query);
        // dd($db_count_results);
        // return [$db_results,$db_count_results];


        array_push($return_value,"2");
        array_push($return_value,$db_results);
        array_push($return_value,$db_count_results);
        
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

    public function set_to_new_contact(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $survey_link=$request->input('myLink');
        // $calling_status=$request->input('calling_status');
        // $respondent_id=$request->input('respondent_id');

        
        date_default_timezone_set('Asia/Dhaka');
        $myDateTime=(string)Carbon::now();

        DB::update('UPDATE `survey_links_'.$project_code.'` SET `interviewed_by`=0,`status`=1 WHERE `survey_link`="'.$survey_link.'"');
        // dd($survey_link);
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

        
        $db_results=DB::select('SELECT users.name AS "InterviewerName", COUNT(sl.interviewed_by) AS ColTotal,
                    SUM(CASE WHEN sl.status=3 THEN 1 ELSE 0 END) as "CompleteInterview",
                    SUM(CASE WHEN sl.status=2 THEN 1 ELSE 0 END) as "IncompleteInterview",
                    SUM(CASE WHEN sl.status=4 THEN 1 ELSE 0 END) as "RingingnotReceived",
                    SUM(CASE WHEN sl.status=5 THEN 1 ELSE 0 END) as "SwitchedOff",
                    SUM(CASE WHEN sl.status=6 THEN 1 ELSE 0 END) as "InvalidNumber"
                FROM survey_links_'.$project_code.' AS sl
                INNER join users on sl.interviewed_by=users.id 
                WHERE sl.interviewed_by>0 AND sl.status>1 AND sl.interview_date BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
                GROUP BY users.name');
        
            $db_total_results=DB::select('SELECT "Total" AS Total, COUNT(sl.interviewed_by) AS ColTotal, 
                SUM(CASE WHEN sl.status=3 THEN 1 ELSE 0 END) as "CompleteInterview",
                SUM(CASE WHEN sl.status=2 THEN 1 ELSE 0 END) as "IncompleteInterview",
                SUM(CASE WHEN sl.status=4 THEN 1 ELSE 0 END) as "RingingnotReceived",
                SUM(CASE WHEN sl.status=5 THEN 1 ELSE 0 END) as "SwitchedOff",
                SUM(CASE WHEN sl.status=6 THEN 1 ELSE 0 END) as "InvalidNumber"
            FROM survey_links_'.$project_code.' AS sl
            INNER join users on sl.interviewed_by=users.id 
            WHERE sl.interviewed_by>0 AND sl.status>1 AND sl.interview_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        // dd($db_total_results);
        return [$db_results,$db_total_results];
    }

    public function export_survey_data(Request $request, $id)
    {
        // $my_query=$this->get_survey_data_query($request,$id);

        $project=Project::find($id);
        $project_code=$project->project_code;


        $filter_qids=$request->input('all_filter_qids');
        $filter_values=$request->input('selected_filter_values');

        $where=$this->get_where_syntax($filter_qids,$filter_values);

        if($where!="")
            $where=' AND '.$where;
        $contact_type=$request->input('contactType');
    
        $my_query=[];
        if($project_code=="23903"){
            if($contact_type==2){
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                a1.attribute_label as PanelBrand, 
                d1.MtoPoint FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where;
            }else{
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                a1.attribute_label as PanelBrand, 
                d1.MtoPoint FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                INNER JOIN attributes_'.$project_code.' as a1 ON d1.PanelBrand=a1.attribute_value and a1.qid="PanelBrand"
                WHERE sl.status='.$contact_type.$where;
            }
        }elseif($project_code=="23902"){
            if($contact_type==2){
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                d1.ShopName, 
                d1.MtoPoint FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.' AND interviewed_by='.Auth::user()->id.$where;
            }else{
                $my_query='SELECT d1.id, 
                CONCAT(" ", d1.RespondentId) as RespondentId, 
                d1.RespName,	
                d1.RespMobile, 
                d1.ShopName, 
                d1.MtoPoint FROM data_sr_'.$project_code.' as d1 
                INNER JOIN survey_links_'.$project_code.' as sl ON d1.RespondentId=sl.RespondentId
                WHERE sl.status='.$contact_type.$where;
            }
        }

        return Excel::download(new SurveyDataExport($my_query), 'Search_Result.xlsx');

    }
}

?>
