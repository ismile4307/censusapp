<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use DB;

class SurveyDataController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        return view('data_analysis.survey_data',['project'=>$project]);
    }

    public function get_survey_data($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

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
        WHERE a1.qid="Centre" AND a2.qid="Thana"');
        
        
        return $db_results;
    }
}

?>
