<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Classes\MyClass;

use DB;
use Auth;
use Str;
use DateTime;

class SetupSurveyLinkController extends Controller
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
        return view ('settings.setup_survey_link',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_panel_data_info($id)
    {
        $project=Project::find($id);
        $total_panel_data=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1');
        $total_survey_link=DB::connection('mysql_2')->select('SELECT COUNT(id) as TotalLink FROM survey_links WHERE project_code='.$project->project_code.' AND interview_type=1 AND `status`=1');
        $total_panel_data_without_link=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1 and RespondentId NOT IN (SELECT RespondentId FROM survey_links_'.$project->project_code.')');
        $total_panel_data_with_link=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1 and RespondentId IN (SELECT RespondentId FROM survey_links_'.$project->project_code.')');
        return [$project,$total_panel_data,$total_survey_link,$total_panel_data_without_link,$total_panel_data_with_link];
    }

    public function set_link_to_panel_data($id){
        $project=Project::find($id);

        $total_panel_data_without_link=DB::select('SELECT RespondentId FROM data_sr_'.$project->project_code.' WHERE status=1 and RespondentId NOT IN (SELECT RespondentId FROM survey_links_'.$project->project_code.')');
        // $total_unused_link=DB::connection('mysql_2')->select('SELECT survey_link FROM survey_links WHERE project_code='.$project->project_code.' AND interview_type=1 AND `status`=1 AND survey_link NOT IN (SELECT survey_link FROM survey_links_'.$project->project_code.')');

        // $total_links=DB::connection('mysql_2')->select('SELECT survey_link FROM survey_links WHERE project_code='.$project->project_code.' AND interview_type=1 AND `status`=1');

        $total_unused_link=$this->get_unused_link($project->project_code);

        $i=0;
        foreach($total_panel_data_without_link as $panel_data){
            DB::insert('INSERT INTO `survey_links_23903`(`RespondentId`, `survey_link`, `interviewed_by`, `interview_date`, `status`) VALUES 
            ('.$panel_data->RespondentId.',"'.$total_unused_link[$i].'",0,"2000-01-01 00:00:00",1)');

            $i++;
        }

        $total_panel_data=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1');
        $total_survey_link=DB::connection('mysql_2')->select('SELECT COUNT(id) as TotalLink FROM survey_links WHERE project_code='.$project->project_code.' AND interview_type=1 AND `status`=1');
        $total_panel_data_without_link=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1 and RespondentId NOT IN (SELECT RespondentId FROM survey_links_'.$project->project_code.')');
        $total_panel_data_with_link=DB::select('SELECT COUNT(id) as TotalData FROM data_sr_'.$project->project_code.' WHERE status=1 and RespondentId IN (SELECT RespondentId FROM survey_links_'.$project->project_code.')');
        return [$project,$total_panel_data,$total_survey_link,$total_panel_data_without_link,$total_panel_data_with_link];
    }

    private function get_unused_link($project_code){
        $total_links=DB::connection('mysql_2')->select('SELECT survey_link FROM survey_links WHERE project_code='.$project_code.' AND interview_type=1 AND `status`=1');
        $total_used_links=DB::select('SELECT survey_link FROM survey_links_'.$project_code);
        $array_total_link=[];
        $array_total_used_link=[];

        foreach($total_links as $link){
            array_push($array_total_link,$link->survey_link);
        }
        foreach($total_used_links as $link){
            array_push($array_total_used_link,$link->survey_link);
        }

        $result=array_diff($array_total_link,$array_total_used_link);
        // print_r(array_values($result));
        return array_values($result);
    }
}
