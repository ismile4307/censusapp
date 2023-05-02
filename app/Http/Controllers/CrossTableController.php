<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class CrossTableController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();
        return view('data_analysis.cross_table',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_table_info($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $table_info=DB::select('SELECT id, qid, question_text, qorder FROM questions_'.$project_code.' WHERE project_code='.$project_code.' AND show_in_cross=1 AND status=1 ORDER by qorder');

        return $table_info;
    }

    public function get_filter_parameter(Request $request, $id)
    {
        
        $all_filter_qinfos=$request['qinfo'];
        
        $filter_attributes=array();

        foreach($all_filter_qinfos as $result){
            array_push($filter_attributes,$this->get_attribute_list($id,$result['qid']));
            // dd($result);
        }
        // dd($filter_attributes);
        return [$all_filter_qinfos,$filter_attributes];
    }

    private function get_attribute_list($id,$qid)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_results=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE project_code='.$project_code.' AND qid="'.$qid.'" ORDER BY attribute_order');
        return $db_results;

    }

    public function get_cross_info(Request $request,$id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $xaxis = $request->xaxis;
        $yaxis = $request->yaxis;
        $zaxis = $request->filter;

        $filter_value=$request->filter_value;

        if(count($xaxis)==1 && count($yaxis)==1 && count($zaxis)==0){
            $xqid = $xaxis[0]['qid'];
            $xid = $xaxis[0]['id'];
            
            $yqid = $yaxis[0]['qid'];
            $yid = $yaxis[0]['id'];

            $all_table=$this->get_data_for_1x1x0($project_code,$xaxis,$yaxis,$zaxis);
            $table_base=$all_table[0];
            $table_count=$all_table[1];
            $table_pct=$all_table[2];
            // dd($all_table);
            $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);
            return [$table_base,$table_count,$table_pct,$attr_label,$xaxis,$yaxis,$zaxis];

        }else if(count($xaxis)==1 && count($yaxis)==1 &&  count($zaxis)==1){
            $xqid = $xaxis[0]['qid'];
            $xid = $xaxis[0]['id'];
            
            $yqid = $yaxis[0]['qid'];
            $yid = $yaxis[0]['id'];

            $zqid = $zaxis[0]['qid'];
            $zid = $zaxis[0]['id'];

            $all_table=$this->get_data_for_1x1x1($project_code,$xaxis,$yaxis,$zaxis,$filter_value);
            $table_base=$all_table[0];
            $table_count=$all_table[1];
            $table_pct=$all_table[2];
            // dd($all_table);
            $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);
            return [$table_base,$table_count,$table_pct,$attr_label,$xaxis,$yaxis,$zaxis];
        }

        
        



    }

    public function get_data_for_1x1x0($project_code,$xaxis,$yaxis,$zaxis){

        $xqid = $xaxis[0]['qid'];
        $xid = $xaxis[0]['id'];
        
        $yqid = $yaxis[0]['qid'];
        $yid = $yaxis[0]['id'];
      

        $xqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.id = "'.$xid.'" AND project_code='.$project_code);
        $yqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.id = "'.$yid.'" AND project_code='.$project_code);

        $yattrib = DB::select('SELECT qid, attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);
        
        if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==1){
            $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            $sum_query='';
            foreach($yattrib  as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);

            $table_count = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.')myData 
                    GROUP BY '.$xqid );

            $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.')myData');

            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

            $all_table=array();

            array_push($all_table,$table_base);
            array_push($all_table,$table_count);
            array_push($all_table,$table_pct);

            return $all_table;            

        } else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==1){
            $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            $sum_query='';
            foreach($yattrib  as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
            $table_count = DB::select($my_query.' 
                FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData 
                    GROUP BY response' );
            
            $table_base = DB::select($my_query.' 
                FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                    FROM `data_sr_'.$project_code.'` as data_sr 
                    INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                    INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                    WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData');
    
            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

            $all_table=array();

            array_push($all_table,$table_base);
            array_push($all_table,$table_count);
            array_push($all_table,$table_pct);

            return $all_table;

        }else if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==2){
            $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            $sum_query='';
            foreach($yattrib  as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
            $table_count = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData 
                    GROUP BY '.$xqid );
            $table_base = DB::select($my_query.' 
            FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                    FROM `data_sr_'.$project_code.'` as data_sr 
                    INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                    INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                    WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData');
        
            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);
            
            $all_table=array();

            array_push($all_table,$table_base);
            array_push($all_table,$table_count);
            array_push($all_table,$table_pct);

            return $all_table;
            

        }else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==2){
            $sumquery = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
        
            foreach($yattrib  as $y ){
                $sumquery =  $sumquery.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            
            $sumquery=Str::substr($sumquery,0,Str::length($sumquery)-1);
            $sumquery = DB::select($sumquery.' 
                FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response as xresponse, att.attribute_label, '.$yqid.'.response
                        FROM '.$xqid.'_'.$project_code.' as '.$xqid.'
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON '.$xqid.'.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData 
                    GROUP BY xresponse' );
                    // UNION SELECT "Total", '.$sumquery.' 
                    // FROM ( SELECT data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                    //         FROM data_sr_'.$project_code.' AS data_sr INNER JOIN attributes AS att ON data_sr.'.$xqid.'=att.attribute_value 
                    //         WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.')myData ');
            
            $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);

            // dd( $sumquery);
            return [$sumquery, $attr_label,$xaxis,$yaxis,$zaxis];
            

        }
    }

    public function get_data_for_1x1x1($project_code,$xaxis,$yaxis,$zaxis,$filter_value){

        $xqid = $xaxis[0]['qid'];
        $xid = $xaxis[0]['id'];
        
        $yqid = $yaxis[0]['qid'];
        $yid = $yaxis[0]['id'];

        $zqid = $zaxis[0]['qid'];
        $zid = $zaxis[0]['id'];
      
        $fltr_value=$filter_value[0];

        $xqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.id = "'.$xid.'" AND project_code='.$project_code);
        $yqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.id = "'.$yid.'" AND project_code='.$project_code);
        $zqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.id = "'.$zid.'" AND project_code='.$project_code);

        $yattrib = DB::select('SELECT qid, attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);
        if($zqtype[0]->qtype==1){
            if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==1){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);

                $table_count = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                            FROM data_sr_'.$project_code.' AS data_sr 
                            INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND data_sr.'.$zqid.'="'.$fltr_value.'")myData 
                        GROUP BY '.$xqid );

                $table_base = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                            FROM data_sr_'.$project_code.' AS data_sr 
                            INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND data_sr.'.$zqid.'="'.$fltr_value.'")myData');

                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;            

            } else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==1){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
                $table_count = DB::select($my_query.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                            FROM `data_sr_'.$project_code.'` as data_sr 
                            INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.'AND data_sr.'.$zqid.'="'.$fltr_value.'") myData 
                        GROUP BY response' );
                
                $table_base = DB::select($my_query.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.'AND data_sr.'.$zqid.'="'.$fltr_value.'") myData');
        
                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;

            }else if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==2){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
                $table_count = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                            FROM `data_sr_'.$project_code.'` as data_sr 
                            INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND data_sr.'.$zqid.'="'.$fltr_value.'") myData 
                        GROUP BY '.$xqid );
                $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND data_sr.'.$zqid.'="'.$fltr_value.'") myData');
            
                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);
                
                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;
                

            }else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==2){
                $sumquery = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            
                foreach($yattrib  as $y ){
                    $sumquery =  $sumquery.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                
                $sumquery=Str::substr($sumquery,0,Str::length($sumquery)-1);
                $sumquery = DB::select($sumquery.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response as xresponse, att.attribute_label, '.$yqid.'.response
                            FROM '.$xqid.'_'.$project_code.' as '.$xqid.'
                            INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON '.$xqid.'.RespondentId='.$yqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData 
                        GROUP BY xresponse' );
                        // UNION SELECT "Total", '.$sumquery.' 
                        // FROM ( SELECT data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        //         FROM data_sr_'.$project_code.' AS data_sr INNER JOIN attributes AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        //         WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.')myData ');
                
                $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);

                // dd( $sumquery);
                return [$sumquery, $attr_label, $xaxis, $yaxis, $zaxis];
                

            }
        }else if($zqtype[0]->qtype==2){
            if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==1){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);

                $table_count = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                            FROM data_sr_'.$project_code.' AS data_sr 
                            INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                            INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'")myData 
                        GROUP BY '.$xqid );

                $table_base = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                            FROM data_sr_'.$project_code.' AS data_sr 
                            INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                            INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'")myData');

                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;            

            } else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==1){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
                $table_count = DB::select($my_query.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                            FROM `data_sr_'.$project_code.'` as data_sr 
                            INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                            INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'") myData 
                        GROUP BY response' );
                
                $table_base = DB::select($my_query.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response, att.attribute_label, data_sr.'.$yqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$xqid.'_'.$project_code.' as '.$xqid.' ON data_sr.RespondentId='.$xqid.'.RespondentId
                        INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'") myData');
        
                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;

            }else if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==2){
                $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
                $sum_query='';
                foreach($yattrib  as $y ){
                    $sum_query =  $sum_query.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                $my_query=$my_query.$sum_query;
                $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
                $table_count = DB::select($my_query.' 
                    FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                            FROM `data_sr_'.$project_code.'` as data_sr 
                            INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                            INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'") myData 
                        GROUP BY '.$xqid );
                $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                        FROM `data_sr_'.$project_code.'` as data_sr 
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN '.$zqid.'_'.$project_code.' as '.$zqid.' ON data_sr.RespondentId='.$zqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.' AND '.$zqid.'.response="'.$fltr_value.'") myData');
            
                $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);
                
                $all_table=array();

                array_push($all_table,$table_base);
                array_push($all_table,$table_count);
                array_push($all_table,$table_pct);

                return $all_table;
                

            }else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==2){
                $sumquery = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            
                foreach($yattrib  as $y ){
                    $sumquery =  $sumquery.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
                }
                
                $sumquery=Str::substr($sumquery,0,Str::length($sumquery)-1);
                $sumquery = DB::select($sumquery.' 
                    FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response as xresponse, att.attribute_label, '.$yqid.'.response
                            FROM '.$xqid.'_'.$project_code.' as '.$xqid.'
                            INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON '.$xqid.'.RespondentId='.$yqid.'.RespondentId
                            INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                            WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.') myData 
                        GROUP BY xresponse' );
                        // UNION SELECT "Total", '.$sumquery.' 
                        // FROM ( SELECT data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        //         FROM data_sr_'.$project_code.' AS data_sr INNER JOIN attributes AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        //         WHERE att.qid="'.$xqid.'" AND att.project_code='.$project_code.')myData ');
                
                $attr_label = DB::select('SELECT attribute_label, attribute_value FROM attributes WHERE attributes.qid = "'.$yqid.'" AND project_code='.$project_code);

                // dd( $sumquery);
                return [$sumquery, $attr_label, $xaxis, $yaxis, $zaxis];
                

            }
        }
    }

    public function get_pct_table_1x1x0($table_base,$table_count)
    {
        $table_pct=[];
        $table_pct=$table_count;

        $myArray=[];
        //Prepare an array from Base table to calculate pct
        foreach($table_base as $base)
        {
            foreach($base as $key=>$value)
                {
                    array_push($myArray,$value);
                }
                break;
        }

        foreach($table_pct as $myData)
        {                
            $i=0;
            foreach($myData as $key=>$value)
            {
                if ( $key!="Label")
                {
                    if($myArray[$i]!=0)
                        $myData->$key=number_format(((int)$value/(int)$myArray[$i]*100),1);
                    else
                        $myData->$key=number_format((0),1);
                }
                $i++;
            }
        }

        return $table_pct;
    }

    public function get_axis_total_1x1($project_code,$xqid,$yqid)
    {
        $y1var=$yqid;

        $y1axis=DB::select('SELECT attributes.qid, attributes.attribute_english, attributes.attribute_value, attributes.attribute_order FROM attributes WHERE attributes.qid="'.$y1var.'" and attributes.project_id='.$project_code.';');
        
        $query='SELECT count(distinct respondent_id) as total, ';
        foreach($y1axis as $y ){
            $query=$query.' SUM(CASE WHEN q_id="'.$y->qid.'" and response = "'.$y->attribute_value.'" THEN 1 ELSE 0 END) as '.$y->qid.$y->attribute_value.',';
        }
    
        $query=Str::substr($query,0,Str::length($query)-1).' FROM (
            SELECT distinct a1.respondent_id, a2.q_id, a2.response
            FROM answers_'.$project_code.' as a1
            INNER JOIN answers_'.$project_code.' as a2 ON a1.respondent_id=a2.respondent_id
            INNER JOIN interview_infos_'.$project_code.' as intv_info ON a2.respondent_id=intv_info.respondent_id 
            WHERE a1.q_id="'.$xqid.'" AND 
                  a2.q_id="'.$yqid.'" AND 
                  intv_info.intv_type=1 AND 
                  intv_info.status=1 AND 
                  intv_info.deleted_at IS null
            )MyData;';

        //return $query;
        
        //dd($query);
        
        $table_total=DB::select($query);
        
        
        return $table_total;
    }

}

?>
