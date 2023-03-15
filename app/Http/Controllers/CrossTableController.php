<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class CrossTableController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        return view('data_analysis.cross_table',['project'=>$project]);
    }

    public function get_table_info($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $table_info=DB::select('SELECT id, qid, question_text, qorder FROM questions WHERE project_code='.$project_code.' AND show_in_frequency=1 AND status=1');

        return $table_info;
    }

    public function get_cross_info(Request $request)
    {
        $xaxis = $request->xaxis;
        $xqid = $xaxis[0]['qid'];
        $id = $xaxis[0]['id'];

        $yaxis = $request->yaxis;
        $yqid = $yaxis[0]['qid'];

        $zaxis = $request->zaxis;

        $qtype = DB::select('SELECT qtype FROM questions WHERE questions.id = "'.$id.'"');

                //dd($qtype[0]->ques_type);

        $sumcolumn = DB::select('SELECT qid, attribute_label, attribute_value FROM attributes WHERE attributes.qid = "'.$yqid.'"');

        $sumquery = '';
        
        foreach($sumcolumn  as $y ){
            $sumquery =  $sumquery.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
        }
        
        $sumquery=Str::substr($sumquery,0,Str::length($sumquery)-1);
        
        //dd($sumquery);

        if($qtype[0]->qtype == 1){
            
            $sumquery = DB::select(' SELECT attribute_label as Label,'.$sumquery.' FROM ( SELECT prodata.'.$xqid.', att.attribute_label, prodata.'.$yqid.' FROM data_sr_23001 AS prodata INNER JOIN attributes AS att ON prodata.'.$xqid.'=att.attribute_value WHERE att.qid="'.$xqid.'")myData GROUP BY '.$xqid.' UNION SELECT "Total", '.$sumquery.' FROM ( SELECT prodata.'.$xqid.', att.attribute_label, prodata.'.$yqid.' FROM data_sr_23001 AS prodata INNER JOIN attributes AS att ON prodata.'.$xqid.'=att.attribute_value WHERE att.qid="'.$xqid.'")myData ');
            
            $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes WHERE attributes.qid = "'.$yqid.'"');

            // dd( $sumquery);
            return [$sumquery, $attr_label,$xaxis,$yaxis,$zaxis];
            

        }



    }


}

?>
