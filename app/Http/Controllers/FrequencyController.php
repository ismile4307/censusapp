<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

use DB;

class FrequencyController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);

        return view('data_analysis.frequency_table',['project'=>$project]);
    }

    public function get_table_info($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $table_info=DB::select('SELECT id, question_text FROM questions WHERE (qtype=1 or qtype=4) AND show_in_frequency=1 and status=1');

        return $table_info;
    }

    public function get_freqyency_table($project_id, $id){

        // $project=Project::find($project_id);
        // $project_code=$project->project_code;

        $ques_id = DB::select('SELECT qtype, qid, question_text FROM  questions WHERE  questions.id = '.$id);

        if($ques_id[0]->qtype == 1){

            $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr_23001.'.$ques_id[0]->qid.') AS Total, ROUND((COUNT(data_sr_23001.'.$ques_id[0]->qid.') * 100 / (SELECT COUNT(data_sr_23001.'.$ques_id[0]->qid.') AS s FROM data_sr_23001 WHERE '.$ques_id[0]->qid.'!="") ), 2) AS Percentage 
            FROM data_sr_23001 INNER JOIN attributes ON data_sr_23001.'.$ques_id[0]->qid.' = attributes.attribute_value WHERE attributes.qid = "'.$ques_id[0]->qid.'" AND data_sr_23001.'.$ques_id[0]->qid.'!="" GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            
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

        }else if($ques_id[0]->qtype==4){

            $db_result = DB::select('SELECT '.$ques_id[0]->qid.' AS Label, COUNT('.$ques_id[0]->qid.') AS Total, 
            round((count('.$ques_id[0]->qid.') * 100 /(SELECT COUNT(('.$ques_id[0]->qid.')) FROM data_sr_23001 
            WHERE '.$ques_id[0]->qid.' != "" ) ),2) AS Percentage FROM data_sr_23001 WHERE '.$ques_id[0]->qid.' != "" 
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