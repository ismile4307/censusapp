<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;

use DB;

class FrequencyController extends Controller
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

        return view('data_analysis.frequency_table',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_table_info($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;
        // dd($project_code);

        $table_info=DB::select('SELECT id, question_text FROM questions_'.$project_code.' WHERE (qtype=1 or qtype=2 or qtype=4 ) AND show_in_frequency=1 and status=1 AND project_code='.$project_code.' ORDER BY qorder');

        return $table_info;
    }

    public function get_freqyency_table($project_id, $id){

        $project=Project::find($project_id);
        $project_code=$project->project_code;

        $ques_id = DB::select('SELECT qtype, qid, question_text FROM  questions_'.$project_code.' WHERE id = '.$id);

        if($ques_id[0]->qtype == 1){

            $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr_'.$project_code.'.'.$ques_id[0]->qid.') AS Total, ROUND((COUNT(data_sr_'.$project_code.'.'.$ques_id[0]->qid.') * 100 / (SELECT COUNT(data_sr_'.$project_code.'.'.$ques_id[0]->qid.') AS s FROM data_sr_'.$project_code.' WHERE '.$ques_id[0]->qid.'!="") ), 2) AS Percentage 
            FROM data_sr_'.$project_code.' INNER JOIN attributes_'.$project_code.' as attributes ON data_sr_'.$project_code.'.'.$ques_id[0]->qid.' = attributes.attribute_value WHERE attributes.qid = "'.$ques_id[0]->qid.'" AND attributes.project_code = '.$project_code.' AND data_sr_'.$project_code.'.'.$ques_id[0]->qid.'!="" GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            
            // dd('SELECT attribute_label AS Label, COUNT('.$ques_id[0]->qid.') AS Total, ROUND((COUNT('.$ques_id[0]->qid.') * 100 / (SELECT COUNT('.$ques_id[0]->qid.') AS s FROM data_sr_23001) ), 2) AS Percentage 
            // FROM (SELECT '.$ques_id[0]->qid.', attribute_label FROM data_sr_23001 INNER JOIN attributes ON data_sr_23001.'.$ques_id[0]->qid.' = attributes.attribute_value WHERE attributes.qid = "'.$ques_id[0]->qid.'" ORDER BY attributes.attribute_order) myData 
            // WHERE '.$ques_id[0]->qid.'!="" GROUP BY '.$ques_id[0]->qid);
            // sort($data);
            $count_total=0;
            $pct_total=0;
            foreach($db_result as $result)
            {
                $count_total=$count_total+$result->Total;
                $pct_total=$pct_total+$result->Percentage;
            }

            $grand_total=array("count_total"=>$count_total, "pct_total"=>round($pct_total,2));

            return response()->json([$db_result, $ques_id[0]->question_text,$grand_total]);

        }else if($ques_id[0]->qtype == 2){

            $base=DB::select('SELECT COUNT(DISTINCT '.$ques_id[0]->qid.'_'.$project_code.'.RespondentId) AS Total FROM '.$ques_id[0]->qid.'_'.$project_code);
// dd($ques_id[0]->qid.'_'.$project_code);
            $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT('.$ques_id[0]->qid.'_'.$project_code.'.response) AS Total, ROUND((COUNT('.$ques_id[0]->qid.'_'.$project_code.'.response) * 100 / (SELECT COUNT(DISTINCT '.$ques_id[0]->qid.'_'.$project_code.'.RespondentId) AS s FROM '.$ques_id[0]->qid.'_'.$project_code.') ), 2) AS Percentage 
            FROM '.$ques_id[0]->qid.'_'.$project_code.' INNER JOIN attributes_'.$project_code.' AS attributes ON '.$ques_id[0]->qid.'_'.$project_code.'.response = attributes.attribute_value WHERE attributes.qid = "'.$ques_id[0]->qid.'"  GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            
            // dd('SELECT attribute_label AS Label, COUNT('.$ques_id[0]->qid.') AS Total, ROUND((COUNT('.$ques_id[0]->qid.') * 100 / (SELECT COUNT('.$ques_id[0]->qid.') AS s FROM data_sr_23001) ), 2) AS Percentage 
            // FROM (SELECT '.$ques_id[0]->qid.', attribute_label FROM data_sr_23001 INNER JOIN attributes ON data_sr_23001.'.$ques_id[0]->qid.' = attributes.attribute_value WHERE attributes.qid = "'.$ques_id[0]->qid.'" ORDER BY attributes.attribute_order) myData 
            // WHERE '.$ques_id[0]->qid.'!="" GROUP BY '.$ques_id[0]->qid);
            // sort($data);
            $count_total=$base[0]->Total;
            $pct_total=0;
            foreach($db_result as $result)
            {
                // $count_total=$count_total+$result->Total;
                $pct_total=$pct_total+$result->Percentage;
            }

            $grand_total=array("count_total"=>$count_total, "pct_total"=>round($pct_total,2));

            return response()->json([$db_result, $ques_id[0]->question_text,$grand_total]);

        }else if($ques_id[0]->qtype==4){

            $db_result = DB::select('SELECT '.$ques_id[0]->qid.' AS Label, COUNT('.$ques_id[0]->qid.') AS Total, 
            round((count('.$ques_id[0]->qid.') * 100 /(SELECT COUNT(('.$ques_id[0]->qid.')) FROM data_sr_'.$project_code.' 
            WHERE '.$ques_id[0]->qid.' != "" ) ),2) AS Percentage FROM data_sr_'.$project_code.' WHERE '.$ques_id[0]->qid.' != "" 
            GROUP BY '.$ques_id[0]->qid);

            sort($db_result);
            $count_total=0;
            $pct_total=0;
            foreach($db_result as $result)
            {
                $count_total=$count_total+$result->Total;
                $pct_total=$pct_total+$result->Percentage;
            }

            $grand_total=array("count_total"=>$count_total, "pct_total"=>round($pct_total,2));

            return response()->json([$db_result, $ques_id[0]->question_text,$grand_total]);

        }
    }
}

?>