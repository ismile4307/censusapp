<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\MyClass;
use App\Models\Project;

use DB;
use Illuminate\Support\Str;

class DashboardInfoCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_data_child01(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $panel_brand = $request->panel_brand;


        // // if($centre_id==0)
            $filter='';
        // // else
        // //     $filter='data_sr_'.$project_code.'.Centre='.$centre_id;
        $my_data=array();
        // //******************Chart 1************** */
        // $table1=DB::select('SELECT a1.attribute_value, a1.attribute_label, COUNT(sl.interviewed_by) AS ColTotal,
        //     SUM(CASE WHEN sl.status=3 THEN 1 ELSE 0 END) as CompleteInterview,
        //     SUM(CASE WHEN (sl.status=2 OR sl.status=4 OR sl.status=5 OR sl.status=6 OR sl.status=7 OR sl.status=8 OR sl.status=9 OR sl.status=10) THEN 1 ELSE 0 END) as UnsuccessfulCall,
            
        //     "0" as "User","0" as "Lapser"
        // FROM survey_links_23903 AS sl
        // INNER join data_sr_23903 AS d1 on sl.RespondentId=d1.RespondentId 
        // INNER join attributes_23903 AS a1 on d1.PanelBrand=a1.attribute_value AND a1.qid="PanelBrand" 
        // WHERE sl.interviewed_by>0 AND sl.status>1 
        // GROUP BY a1.attribute_value, a1.attribute_label');

        // // dd($table1);
        // $x1var='Qpanel';
        // $y1var='Q4';

        // $table2=$this->get_cross_table_count($project_code,$x1var,$y1var,$filter);
        // // dd($table2[1]);
        // //*********************************************** Sample Achieved Table ***********************
        // // $x1axis=DB::select('SELECT attributes.qid, attributes.attribute_english, attributes.attribute_value, attributes.attribute_order FROM attributes WHERE attributes.qid="'.$x1var.'" and attributes.project_id='.$project_code.';');
        // // $y1axis=DB::select('SELECT attributes.qid, attributes.attribute_english, attributes.attribute_value, attributes.attribute_order FROM attributes WHERE attributes.qid="'.$y1var.'" and attributes.project_id='.$project_code.';');
        
        
        // // $columnsum=[];
        // // //return $yaxis;
        // // $query='SELECT response1, attribValue, ';
        // // // $colNo=0;
        // // //This is for Total
        // // // $query=$query.' SUM(CASE WHEN q_id2="'.$y1axis[0]->qid.'" THEN 1 ELSE 0 END) as '.$y1axis[0]->qid.'Total,';
        // // // $columnsum[0]=0;
        // // foreach($y1axis as $y ){
        // //     $query=$query.' SUM(CASE WHEN q_id2="'.$y->qid.'" and response2 = "'.$y->attribute_value.'" THEN 1 ELSE 0 END) as '.$y->qid.$y->attribute_value.',';
        // //     // $columnsum[$colNo]=0;
        // //     $colNo++;
        // // }

        // // // return $columnsum;
    
        // // $query=Str::substr($query,0,Str::length($query)-1).' FROM (
        // //     SELECT DISTINCT c1.respondent_id, c1.q_id as q_id1, attributes.attribute_english as response1, attributes.attribute_value as attribValue, c2.q_id as q_id2, c2.response as response2 FROM answers_'.$project_code.' as c1 
        // //     INNER JOIN interview_infos_'.$project_code.' as c0 ON c0.id = c1.interview_info_id 
        // //     INNER JOIN answers_'.$project_code.' as c2 ON c1.interview_info_id = c2.interview_info_id 
        // //     INNER JOIN attributes ON attributes.attribute_value= c1.response 
        // //     WHERE c1.q_id="'.$x1var.'" and c2.q_id="'.$y1var.'" and attributes.qid="'.$x1var.'" and attributes.project_id="'.$project_code.'" and c0.intv_type="1" and c0.status="1" and c0.deleted_at is NULL
        // // ) allData GROUP BY response1, attribValue ORDER BY attribValue;';

        // // // return $query;
        // // $table2=DB::select($query);
        
        // // // dd($table2);
        
        // // $table3=DB::select('SELECT response1, attribValue, 
        // //                     SUM(CASE WHEN q_id2="Intro" and response2 = "1" THEN 1 ELSE 0 END) as Intro1, 
        // //                     SUM(CASE WHEN q_id2="Intro" and response2 = "2" THEN 1 ELSE 0 END) as Intro2 
        // //                     FROM ( SELECT DISTINCT c1.respondent_id, c1.q_id as q_id1, attributes.attribute_english as response1, attributes.attribute_value as attribValue, c2.q_id as q_id2, c2.response as response2 
        // //                             FROM answers_23903 as c1 
        // //                             INNER JOIN interview_infos_23903 as c0 ON c0.id = c1.interview_info_id 
        // //                             INNER JOIN answers_23903 as c2 ON c1.interview_info_id = c2.interview_info_id 
        // //                             INNER JOIN attributes ON attributes.attribute_value= c1.response 
        // //                             WHERE c1.q_id="QPanel" and c2.q_id="Intro" and attributes.qid="QPanel" and attributes.project_id="23903" and c0.intv_type="1" and (c0.status="1" OR c0.status="3") and c0.deleted_at is NULL ) allData 
        // //                     GROUP BY response1, attribValue ORDER BY attribValue;');
        
        // // // dd($table3);
        
        // foreach($table1 as $table_x){
        //     foreach($table2[1] as $table_y){
        //         if($table_x->attribute_value==$table_y->attribValue){
        //             $table_x->User=$table_y->Q41;
        //             $table_x->Lapser=$table_y->Q42;
        //         }
        //     }
        // }

        // foreach($table1 as $table_x){
        //     foreach($table3 as $table_z){
        //         if($table_x->attribute_value==$table_z->attribValue){
        //             $table_x->TerminateInterview=$table_z->Intro2;
        //         }
        //     }
        // }
        // dd($table1);

        // $columnsum=DB::select('SELECT "Total" AS Total, COUNT(sl.interviewed_by) AS ColTotal, 
        //     SUM(CASE WHEN sl.status=3 THEN 1 ELSE 0 END) as CompleteInterview,
        //     SUM(CASE WHEN (sl.status=2 OR sl.status=4 OR sl.status=5 OR sl.status=6 OR sl.status=7 OR sl.status=8 OR sl.status=9 OR sl.status=10) THEN 1 ELSE 0 END) as UnsuccessfulCall,
            
        //     "0" as "User","0" as "Lapser"
        // FROM survey_links_23903 AS sl
        // INNER join data_sr_'.$project_code.' AS d1 on sl.RespondentId=d1.RespondentId 
        // INNER join attributes_'.$project_code.' AS a1 on d1.Qpanel=a1.attribute_value AND a1.qid="Qpanel" 
        // WHERE sl.interviewed_by>0 AND sl.status>1');
        
        // foreach($table1 as $table_x){
        //     foreach($columnsum as $table_y){
        //         $table_y->User=$table_y->User+$table_x->User;
        //         $table_y->Lapser=$table_y->Lapser+$table_x->Lapser;
        //     }
        // }
        
        // dd($columnsum);
        $dummyArray=Array();
        array_push($my_data,[]);
        array_push($my_data,'');

        // array_push($tablestruct,'CxC');
        // array_push($alltables, $table1);
        // array_push($alltabletitles, $table_title);
        // array_push($allx1axis, $x1axis);   //additional no needs
        // array_push($allx2axis, $x1axis);   //additional no needs
        // array_push($allx3axis, $x1axis);   //additional no needs
        // array_push($ally1axis, $y1axis);   //additional no needs
        // array_push($ally2axis, $y1axis);   //additional no needs
        // array_push($ally3axis, $y1axis);   //additional no needs
        // array_push($allcoltot, $columnsum);
        // array_push($alltabletype, '1x1S');
        // // dd($alltables);
        

        
        //******************Chart 2****************
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Qpanel',$filter);
        // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
        // dd($my_data);
        
        //******************Chart 3****************
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q4',$filter);
        // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
        // dd($my_data);

        //******************Chart 5****************
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q3',$filter);
        // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
        // dd($my_data);

        //******************Chart 6****************
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q4','Qpanel',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        //******************Chart 7****************
        // $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $filter='';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q6',$filter);

        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
        
        //******************Chart 8****************
        $filter='data_sr.Q4="1"';
        // $filter='';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q6',$filter);

        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 8****************
        $filter='data_sr.Q4="2"';
        // $filter='';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q6',$filter);

        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        return $my_data;
    }


    public function get_data_child02(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $panel_brand = $request->panel_brand;

        // if($centre_id==0)
            $filter='';
        // else
            // $filter='data_sr_'.$project_code.'.Qpanel=1';

        $my_data=array();
        //******************Chart 1****************

        $panel_size=DB::select('SELECT Count(id) as Total FROM `data_sr_23903` WHERE PanelBrand="'.$panel_brand.'"');
        $panel_achieved=DB::select('SELECT Count(id) as Total FROM `data_sr_239031` WHERE Qpanel="'.$panel_brand.'"');

        array_push($my_data,$panel_size);
        array_push($my_data,$panel_achieved[0]->Total);

        // $chart1_data=$this->get_frequency_table($project_code,'Qpanel',$filter);
        // //$chart2_base=$this->get_base($project_code,'Qpanel',1,$filter);
        // // dd($chart1_data);
        // $my_data1=array();
        
        // $header1=array("Panel Size","Percentage");
        // array_push($my_data1,$header1);

        // // dd($chart2_data[0]);
        // $i=0;
        // foreach($chart1_data[0] as $data)
        // {
        //     if($i==0){
        //   $share=array($data->Label,(double)$data->Percentage);
        //   array_push($my_data1,$share);
        //     }
        //     $i++;
        // }
        // array_push($my_data,$my_data1);
        // array_push($my_data,$chart1_data[1][0]->base);
        // dd($my_data);
        
        //******************Chart 2****************
        $filter='data_sr.Qpanel='.$panel_brand;
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q4',$filter);
                // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
               
        
        //******************Chart 3****************
        $filter='data_sr.Qpanel="'.$panel_brand.'" AND Q4="2"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'shop_type',$filter);
         // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 4****************
        $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q7','Q4',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        //******************Chart 5****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q8',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);


        //******************Chart 6****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q9',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 7****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q3',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        return $my_data;
    }

    public function get_data_child03(Request $request, $id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $panel_brand=$request->panel_brand;
        // if($centre_id==0)
            $filter='';
        // else
            // $filter='data_sr_'.$project_code.'.Qpanel=1';

        $my_data=array();
        //******************Chart 1****************

        $panel_size=DB::select('SELECT Count(id) as Total FROM `data_sr_23903` WHERE PanelBrand="'.$panel_brand.'"');
        $panel_achieved=DB::select('SELECT Count(id) as Total FROM `data_sr_239031` WHERE Qpanel="'.$panel_brand.'"');

        array_push($my_data,$panel_size);
        array_push($my_data,$panel_achieved[0]->Total);

        // $chart1_data=$this->get_frequency_table($project_code,'Qpanel',$filter);
        // //$chart2_base=$this->get_base($project_code,'Qpanel',1,$filter);
        // // dd($chart1_data);
        // $my_data1=array();
        
        // $header1=array("Panel Size","Percentage");
        // array_push($my_data1,$header1);

        // // dd($chart2_data[0]);
        // $i=0;
        // foreach($chart1_data[0] as $data)
        // {
        //     if($i==0){
        //   $share=array($data->Label,(double)$data->Percentage);
        //   array_push($my_data1,$share);
        //     }
        //     $i++;
        // }
        // array_push($my_data,$my_data1);
        // array_push($my_data,$chart1_data[1][0]->base);
        // // dd($my_data);
        
        //******************Chart 2****************
        $filter='data_sr.Qpanel='.$panel_brand;
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q4',$filter);
                // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);
               
        
        //******************Chart 3****************
        $filter='data_sr.Qpanel="'.$panel_brand.'" AND Q4="2"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'shop_type',$filter);
         // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 4****************
        $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q7','Q4',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        //******************Chart 5****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q8',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);


        //******************Chart 6****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q9',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 7****************
        $filter='data_sr.Qpanel="'.$panel_brand.'"';
        $freq_table=$this->get_frequency_table_for_chart($project_code,'Q3',$filter);
            // dd($my_data);
        array_push($my_data,$freq_table[0]);
        array_push($my_data,$freq_table[1]);

        //******************Chart 8****************
        $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q4','Q11',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        //******************Chart 9****************
        $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q4','Q12',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        //******************Chart 10****************
        $filter=' AND data_sr.Qpanel="'.$panel_brand.'"';
        $cross_table=$this->get_cross_table_for_chart($project_code,'Q4','Q12All',$filter);

        array_push($my_data,$cross_table[0]);
        array_push($my_data,$cross_table[1]);

        return $my_data;
    }


    private function get_frequency_table_for_chart($project_code,$qid,$filter){
        $my_table_data=array();

        $chart_data=$this->get_frequency_table($project_code,$qid,$filter);
        //$chart2_base=$this->get_base($project_code,'Qpanel',1,$filter);
        // dd($chart1_data);
        $my_data=array();
        
        $header=array("Panel Size","Percentage");
        array_push($my_data,$header);

        // dd($chart2_data[0]);
        foreach($chart_data[0] as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data,$share);
         
        }
        array_push($my_table_data,$my_data);
        array_push($my_table_data,$chart_data[1][0]->base);

        return $my_table_data;
    }

    private function get_cross_table_for_chart($project_code,$xqid,$yqid,$filter){
        $my_table_data=array();

        $chart_data=$this->get_cross_table($project_code,$xqid,$yqid,$filter);
        // $chart6_base=$this->get_base($project_code,'Q3',2,$filter);
        // dd($chart6_data[0]);
        $my_data=array();
        $header=array("Brand Name");
        foreach($chart_data[1] as $data)
        {
            array_push($header, $data->Label);
        }
        // dd($header5);
        array_push($my_data,$header);

        $yattibs=$chart_data[0];
        // dd($yattibs);
        
        foreach($yattibs as $y)
        {
            $share=array();
            array_push($share,$y->attribute_label);
            for($i=0;$i<count($chart_data[1]);$i++)
            {
                $key=$y->qid.$y->attribute_value;
                $data=$chart_data[1][$i]->$key;
                // dd($datas);
                array_push($share,(double)$data);
            }
            // dd($share);
            array_push($my_data,$share);
        }

        // dd($chart_data[2]);
        array_push($my_table_data,$my_data);
        array_push($my_table_data,$chart_data[2]);
        // dd($my_data[7]);

        return $my_table_data;
    }


















    private function get_frequency_table($project_code,$qid,$filter)
    {
        $qinfos = DB::select('SELECT qtype, qid, question_text FROM  questions_'.$project_code.' WHERE qid = "'.$qid.'"');

        if($qinfos[0]->qtype==1)
        {
            if($filter=='')
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr.'.$qid.') AS Total, ROUND((COUNT(data_sr.'.$qid.') * 100 / (SELECT COUNT(data_sr.'.$qid.') AS s FROM data_sr_'.$project_code.' AS data_sr WHERE data_sr.'.$qid.'!="") ), 2) AS Percentage 
                FROM data_sr_'.$project_code.' AS data_sr INNER JOIN attributes_'.$project_code.' AS attributes ON data_sr.'.$qid.' = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND data_sr.'.$qid.'!="" GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');

                $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS base FROM data_sr_'.$project_code.' WHERE '.$qid.'!=""');
            }
            else
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr.'.$qid.') AS Total, ROUND((COUNT(data_sr.'.$qid.') * 100 / (SELECT COUNT(data_sr.'.$qid.') AS s FROM data_sr_'.$project_code.' AS data_sr WHERE '.$qid.'!="" AND '.$filter.') ), 2) AS Percentage 
                FROM data_sr_'.$project_code.' as data_sr INNER JOIN attributes_'.$project_code.' AS attributes ON data_sr.'.$qid.' = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND data_sr.'.$qid.'!="" AND '.$filter.' GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');

                $base = DB::select('SELECT COUNT(data_sr.'.$qid.') AS base FROM data_sr_'.$project_code.' AS data_sr WHERE data_sr.'.$qid.'!="" AND '.$filter);
            }
            return [$db_result,$base];
        }
        else if($qinfos[0]->qtype==2)
        {
            if($filter=='')
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT('.$qid.'_'.$project_code.'.response) AS Total, ROUND((COUNT('.$qid.'_'.$project_code.'.response) * 100 / (SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS s FROM '.$qid.'_'.$project_code.') ), 2) AS Percentage 
                FROM '.$qid.'_'.$project_code.' INNER JOIN attributes_'.$project_code.' as attributes ON '.$qid.'_'.$project_code.'.response = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.'  GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');

                $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base FROM '.$qid.'_'.$project_code);
            }
            else
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT('.$qid.'_'.$project_code.'.response) AS Total, ROUND((COUNT('.$qid.'_'.$project_code.'.response) * 100 / (SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS s FROM '.$qid.'_'.$project_code.' INNER JOIN data_sr_'.$project_code.' AS data_sr ON data_sr.RespondentId = '.$qid.'_'.$project_code.'.RespondentId WHERE '.$filter.') ), 2) AS Percentage 
                FROM '.$qid.'_'.$project_code.' 
                INNER JOIN attributes_'.$project_code.' as attributes ON '.$qid.'_'.$project_code.'.response = attributes.attribute_value 
                INNER JOIN data_sr_'.$project_code.' AS data_sr ON data_sr.RespondentId = '.$qid.'_'.$project_code.'.RespondentId
                WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND '.$filter.' GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');

                $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base 
                FROM '.$qid.'_'.$project_code.'
                INNER JOIN data_sr_'.$project_code.' AS data_sr ON data_sr.RespondentId = '.$qid.'_'.$project_code.'.RespondentId
                WHERE '.$filter);

                // dd('$base');
            }
            return [$db_result,$base];
        }

    }

    private function get_cross_table_count($project_code,$xqid,$yqid,$filter)
    {
        $xqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.qid = "'.$xqid.'"');
        $yqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.qid = "'.$yqid.'"');

        $yattrib = DB::select('SELECT qid, attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'"');

        // $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$xqid.') AS base FROM data_sr_'.$project_code.' WHERE '.$xqid.'!=""');
        $base ='';
        if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==1){
            $my_query = ' SELECT attribute_label as Label, attribute_value as attribValue, count(DISTINCT RespondentId  ) as total, ';
            $sum_query='';
            foreach($yattrib as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);

            $table_count = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, att.attribute_value, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'"'.$filter.')myData 
                    GROUP BY '.$xqid );

            $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, att.attribute_value, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'"'.$filter.')myData');

            $base = $table_base[0]->total;

            // $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

            $all_table=array();

            // array_push($all_table,$table_base);
            // array_push($all_table,$table_count);
            array_push($all_table,$yattrib);
            array_push($all_table,$table_count);
            array_push($all_table,$base);

            return $all_table;            

        }
    }
    private function get_cross_table($project_code,$xqid,$yqid,$filter)
    {
        $xqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.qid = "'.$xqid.'"');
        $yqtype = DB::select('SELECT qtype FROM questions_'.$project_code.' AS questions WHERE questions.qid = "'.$yqid.'"');

        $yattrib = DB::select('SELECT qid, attribute_label, attribute_value FROM attributes_'.$project_code.' AS attributes WHERE attributes.qid = "'.$yqid.'"');

        // $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$xqid.') AS base FROM data_sr_'.$project_code.' WHERE '.$xqid.'!=""');
        $base ='';
        if($xqtype[0]->qtype == 1 && $yqtype[0]->qtype==1){
            $my_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
            $sum_query='';
            foreach($yattrib as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN '.$y->qid.'='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);

            $table_count = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'"'.$filter.')myData 
                    GROUP BY '.$xqid );

            $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, data_sr.'.$xqid.', att.attribute_label, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr 
                        INNER JOIN attributes_'.$project_code.' AS att ON data_sr.'.$xqid.'=att.attribute_value 
                        WHERE att.qid="'.$xqid.'"'.$filter.')myData');

            $base = $table_base[0]->total;

            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

            $all_table=array();

            // array_push($all_table,$table_base);
            // array_push($all_table,$table_count);
            array_push($all_table,$yattrib);
            array_push($all_table,$table_pct);
            array_push($all_table,$base);

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
                        WHERE att.qid="'.$xqid.'"'.$filter.') myData 
                    GROUP BY response' );
            
            if($filter!=''){
            $table_base = DB::select($my_query.' 
                FROM ( SELECT data_sr.RespondentId, "attribute_label" as attribute_label, data_sr.'.$yqid.' 
                        FROM data_sr_'.$project_code.' AS data_sr )myData');
            }
                        else{
                            $table_base = DB::select($my_query.' 
                            FROM ( SELECT data_sr.RespondentId, "attribute_label" as attribute_label, data_sr.'.$yqid.' 
                                    FROM data_sr_'.$project_code.' AS data_sr WHERE data_sr.RespondentId>0'.$filter.' )myData');
                        }
            
            $base = $table_base[0]->total;

            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);

            $all_table=array();

            // array_push($all_table,$table_base);
            // array_push($all_table,$table_count);
            array_push($all_table,$yattrib);
            array_push($all_table,$table_pct);
            array_push($all_table,$base);
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
                        WHERE att.qid="'.$xqid.'") myData 
                    GROUP BY '.$xqid );
            $table_base = DB::select($my_query.' 
            FROM ( SELECT data_sr.RespondentId, '.$yqid.'.response, att.attribute_label, data_sr.'.$xqid.'
                    FROM `data_sr_'.$project_code.'` as data_sr 
                    INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON data_sr.RespondentId='.$yqid.'.RespondentId
                    INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'=att.attribute_value 
                    WHERE att.qid="'.$xqid.'") myData');
                    
            $base = $table_base[0]->total;
            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);
            
            $all_table=array();

            // array_push($all_table,$table_base);
            // array_push($all_table,$table_count);
            array_push($all_table,$yattrib);
            array_push($all_table,$table_pct);
            array_push($all_table,$base);
            return $all_table;
            

        }else if($xqtype[0]->qtype == 2 && $yqtype[0]->qtype==2){
            $sum_query = ' SELECT attribute_label as Label, count(DISTINCT RespondentId  ) as total, ';
    
            foreach($yattrib  as $y ){
                $sum_query =  $sum_query.' SUM(CASE WHEN response='.$y->attribute_value.' THEN 1 ELSE 0 END ) AS '.$y->qid.$y->attribute_value.',';
            }
            
            $my_query=$my_query.$sum_query;
            $my_query=Str::substr($my_query,0,Str::length($my_query)-1);
            $table_count = DB::select($my_query.' 
                FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response as xresponse, att.attribute_label, '.$yqid.'.response
                        FROM '.$xqid.'_'.$project_code.' as '.$xqid.'
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON '.$xqid.'.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'") myData 
                    GROUP BY xresponse' );
                    

            $table_base = DB::select($my_query.' 
                FROM ( SELECT '.$xqid.'.RespondentId, '.$xqid.'.response as xresponse, att.attribute_label, '.$yqid.'.response
                        FROM '.$xqid.'_'.$project_code.' as '.$xqid.'
                        INNER JOIN '.$yqid.'_'.$project_code.' as '.$yqid.' ON '.$xqid.'.RespondentId='.$yqid.'.RespondentId
                        INNER JOIN attributes_'.$project_code.' AS att ON '.$xqid.'.response=att.attribute_value 
                        WHERE att.qid="'.$xqid.'") myData');
        
            $table_pct=$this->get_pct_table_1x1x0($table_base,$table_count);
            
            $all_table=array();

            // array_push($all_table,$table_base);
            // array_push($all_table,$table_count);
            array_push($all_table,$yattrib);
            array_push($all_table,$table_pct);
            array_push($all_table,$base);
            // dd( $sumquery);
            return $all_table;
            

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

    // private function get_base($project_code,$qid,$qtype,$filter)
    // {
    //     if($qtype==1)
    //     {
    //         if($filter=='')
    //         {
    //             $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS base FROM data_sr_'.$project_code.' WHERE '.$qid.'!=""');
    //         }
    //         else
    //         {
    //             $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS base FROM data_sr_'.$project_code.' WHERE '.$qid.'!="" AND '.$filter);
    //         }
    //         return $base;
    //     }
    //     else if($qtype==2)
    //     {
    //         if($filter=='')
    //         {
    //             $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base FROM '.$qid.'_'.$project_code);
    //         }
    //         else
    //         {
    //             $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base 
    //             FROM '.$qid.'_'.$project_code.'
    //             INNER JOIN data_sr_'.$project_code.' ON data_sr_'.$project_code.'.RespondentId = '.$qid.'_'.$project_code.'.RespondentId
    //             WHERE '.$filter);
    //         }

    //         return $base;
    //     }
    // }
}
