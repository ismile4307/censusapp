<?php

namespace App\Http\Controllers;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;

use DB;

class DashboardController extends Controller
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
        return view('data_analysis.dashboard',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_center_d1($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Centre" AND project_code='.$project_code);
        
        return $db_result;
    }

    public function get_center_d2($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result1=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Centre" AND project_code='.$project_code);
        $db_result2=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Q16" AND project_code='.$project_code);
        
        $db_result=array($db_result1,$db_result2);

        return $db_result;
    }
    
    public function get_center_d3($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result1=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Centre" AND project_code='.$project_code);
        $db_result2=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Q16" AND project_code='.$project_code);
        
        $db_result=array($db_result1,$db_result2);

        return $db_result;
    }

    public function get_center_d4($id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $db_result1=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Centre" AND project_code='.$project_code);
        $db_result2=DB::select('SELECT attribute_value, attribute_label FROM attributes_'.$project_code.' WHERE qid="Q16" AND project_code='.$project_code);
        
        $db_result=array($db_result1,$db_result2);

        return $db_result;
    }

    public function dashboard1(Request $request,$id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $centre_id = $request->center_id;

        if($centre_id==0)
            $filter='';
        else
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id;

        $my_data=array();
        //******************Chart 1****************
        $chart1_data=$this->get_frequency_table($project_code,'Q16',1,$filter);
        $chart1_base=$this->get_base($project_code,'Q16',1,$filter);
        // dd($chart1_data);
        $my_data1=array();
        $header1=array("Store type","Percentage");
        array_push($my_data1,$header1);

        foreach($chart1_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data1,$share);
        }
        array_push($my_data,$my_data1);
        array_push($my_data,$chart1_base[0]->base);
        // dd($my_data);
        
        //******************Chart 2****************
        $chart2_data=$this->get_frequency_table($project_code,'TypeOfArea',1,$filter);
        $chart2_base=$this->get_base($project_code,'TypeOfArea',1,$filter);
        // dd($chart1_data);
        $my_data2=array();
        $header2=array("Type of area","Percentage");
        array_push($my_data2,$header2);

        foreach($chart2_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data2,$share);
        }
        array_push($my_data,$my_data2);
        array_push($my_data,$chart2_base[0]->base);
        // dd($my_data);

        //******************Chart 3****************
        $chart3_data=$this->get_frequency_table($project_code,'Q16a',2,$filter);
        $chart3_base=$this->get_base($project_code,'TypeOfArea',1,$filter);
        // dd($chart1_data);
        $my_data3=array();
        $header3=array("Category sale","Percentage");
        array_push($my_data3,$header3);

        foreach($chart3_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data3,$share);
        }
        array_push($my_data,$my_data3);
        array_push($my_data,$chart3_base[0]->base);

        // dd($my_data);
            return $my_data;
    }


    public function dashboard2(Request $request,$id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $centre_id = $request->center_id;
        $shop_type_id = $request->shop_type_id;

        if($centre_id==0 && $shop_type_id==0)
            $filter='';
        else if($centre_id>0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id.' AND data_sr_'.$project_code.'.Q16='.$shop_type_id;
        else if($centre_id>0 && $shop_type_id==0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id;
        else if($centre_id==0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Q16='.$shop_type_id;

            // dd($filter);
        $my_data=array();
        //******************Chart 1****************
        $chart1_data=$this->get_frequency_table($project_code,'Q17a',2,$filter);
        $chart1_base=$this->get_base($project_code,'Q17a',2,$filter);
        // dd($chart1_data);
        $my_data1=array();
        $header1=array("Store type","Percentage");
        array_push($my_data1,$header1);

        foreach($chart1_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data1,$share);
        }
        array_push($my_data,$my_data1);
        array_push($my_data,$chart1_base[0]->base);
        // dd($my_data);
        
        //******************Chart 2****************
        $chart2_data=[];
        if($filter=='')
            {
                $chart2_data=DB::select('SELECT AVG(Q181) as avg_Q181,AVG(Q182) as avg_Q182,AVG(Q183) as avg_Q183 FROM `data_sr_23002`');
            }
        else
            {
                $chart2_data=DB::select('SELECT AVG(Q181) as avg_Q181,AVG(Q182) as avg_Q182,AVG(Q183) as avg_Q183 
            FROM `data_sr_23002` WHERE '.$filter);
            }

        $chart2_base="";
        // dd($chart1_data);
        $my_data2=array();
        $header2=array("Type of area","Percentage");
        array_push($my_data2,$header2);

        // foreach($chart2_data as $data)
        // {
          $share1=array("Marks",Round((double)$chart2_data[0]->avg_Q181,2));
          array_push($my_data2,$share1);
          $share2=array("AMA",Round((double)$chart2_data[0]->avg_Q182,2));
          array_push($my_data2,$share2);
          $share3=array("Starship",Round((double)$chart2_data[0]->avg_Q183,2));
          array_push($my_data2,$share3);

        // }
        array_push($my_data,$my_data2);
        array_push($my_data,"0");



        // // dd($my_data);

        //******************Chart 3****************
        $chart3_data=$this->get_frequency_table($project_code,'Q191',2,$filter);
        $chart3_base=$this->get_base($project_code,'Q191',2,$filter);
        // dd($chart1_data);
        $my_data3=array();
        $header3=array("Category sale","Percentage");
        array_push($my_data3,$header3);

        foreach($chart3_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data3,$share);
        }
        array_push($my_data,$my_data3);
        array_push($my_data,$chart3_base[0]->base);

        // dd($my_data);

        //******************Chart 4****************
        $chart4_data=$this->get_frequency_table($project_code,'Q192',2,$filter);
        $chart4_base=$this->get_base($project_code,'Q192',2,$filter);
        // dd($chart1_data);
        $my_data4=array();
        $header4=array("Category sale","Percentage");
        array_push($my_data4,$header4);

        foreach($chart4_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data4,$share);
        }
        array_push($my_data,$my_data4);
        array_push($my_data,$chart4_base[0]->base);

        //******************Chart 5****************
        $chart5_data=$this->get_frequency_table($project_code,'Q193',2,$filter);
        $chart5_base=$this->get_base($project_code,'Q193',2,$filter);
        // dd($chart1_data);
        $my_data5=array();
        $header5=array("Category sale","Percentage");
        array_push($my_data5,$header5);

        foreach($chart5_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data5,$share);
        }
        array_push($my_data,$my_data5);
        array_push($my_data,$chart5_base[0]->base);

        // dd($my_data);    
            return $my_data;
    }

    public function dashboard3(Request $request,$id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $centre_id = $request->center_id;
        $shop_type_id = $request->shop_type_id;

        if($centre_id==0 && $shop_type_id==0)
            $filter='';
        else if($centre_id>0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id.' AND data_sr_'.$project_code.'.Q16='.$shop_type_id;
        else if($centre_id>0 && $shop_type_id==0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id;
        else if($centre_id==0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Q16='.$shop_type_id;

            // dd($filter);
        $my_data=array();
        //******************Chart 1****************
        $chart1_data=$this->get_frequency_table($project_code,'Q21a',2,$filter);
        $chart1_base=$this->get_base($project_code,'Q21a',2,$filter);
        // dd($chart1_data);
        $my_data1=array();
        $header1=array("Store type","Percentage");
        array_push($my_data1,$header1);

        foreach($chart1_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data1,$share);
        }
        array_push($my_data,$my_data1);
        array_push($my_data,$chart1_base[0]->base);
        // dd($my_data);
        
        //******************Chart 2****************
        $chart2_data=[];
        if($filter=='')
            {
                $chart2_data=DB::select('SELECT AVG(Q221) as avg_Q221,AVG(Q222) as avg_Q222 FROM `data_sr_23002`');
            }
        else
            {
                $chart2_data=DB::select('SELECT AVG(Q221) as avg_Q221,AVG(Q222) as avg_Q222 
            FROM `data_sr_'.$project_code.'` WHERE '.$filter);
            }

        $chart2_base="";
        // dd($chart1_data);
        $my_data2=array();
        $header2=array("Type of area","Percentage");
        array_push($my_data2,$header2);

        // foreach($chart2_data as $data)
        // {
          $share1=array("Seylon",Round((double)$chart2_data[0]->avg_Q221,2));
          array_push($my_data2,$share1);
          $share2=array("Starship",Round((double)$chart2_data[0]->avg_Q222,2));
          array_push($my_data2,$share2);
        //   $share3=array("Starship",Round((double)$chart2_data[0]->avg_Q183,2));
        //   array_push($my_data2,$share3);

        // }
        array_push($my_data,$my_data2);
        array_push($my_data,"0");



        // // dd($my_data);

        //******************Chart 3****************
        $chart3_data=$this->get_frequency_table($project_code,'Q231',2,$filter);
        $chart3_base=$this->get_base($project_code,'Q231',2,$filter);
        // dd($chart1_data);
        $my_data3=array();
        $header3=array("Category sale","Percentage");
        array_push($my_data3,$header3);

        foreach($chart3_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data3,$share);
        }
        array_push($my_data,$my_data3);
        array_push($my_data,$chart3_base[0]->base);

        // dd($my_data);

        //******************Chart 4****************
        $chart4_data=$this->get_frequency_table($project_code,'Q232',2,$filter);
        $chart4_base=$this->get_base($project_code,'Q232',2,$filter);
        // dd($chart1_data);
        $my_data4=array();
        $header4=array("Category sale","Percentage");
        array_push($my_data4,$header4);

        foreach($chart4_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data4,$share);
        }
        array_push($my_data,$my_data4);
        array_push($my_data,$chart4_base[0]->base);

        //******************Chart 5****************
        $chart5_data=$this->get_frequency_table($project_code,'Q193',2,$filter);
        $chart5_base=$this->get_base($project_code,'Q193',2,$filter);
        // dd($chart1_data);
        $my_data5=array();
        $header5=array("Category sale","Percentage");
        array_push($my_data5,$header5);

        foreach($chart5_data as $data)
        {
        $share=array($data->Label,(double)$data->Percentage);
        array_push($my_data5,$share);
        }
        array_push($my_data,$my_data5);
        array_push($my_data,$chart5_base[0]->base);

        // dd($my_data);    
            return $my_data;
    }

    public function dashboard4(Request $request,$id)
    {
        $project=Project::find($id);
        $project_code=$project->project_code;

        $centre_id = $request->center_id;
        $shop_type_id = $request->shop_type_id;

        if($centre_id==0 && $shop_type_id==0)
            $filter='';
        else if($centre_id>0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id.' AND data_sr_'.$project_code.'.Q16='.$shop_type_id;
        else if($centre_id>0 && $shop_type_id==0)
            $filter='data_sr_'.$project_code.'.Centre='.$centre_id;
        else if($centre_id==0 && $shop_type_id>0)
            $filter='data_sr_'.$project_code.'.Q16='.$shop_type_id;

            // dd($filter);
        $my_data=array();
        //******************Chart 1****************
        $chart1_data=$this->get_frequency_table($project_code,'Q26',2,$filter);
        $chart1_base=$this->get_base($project_code,'Q26',2,$filter);
        // dd($chart1_data);
        $my_data1=array();
        $header1=array("Store type","Percentage");
        array_push($my_data1,$header1);

        foreach($chart1_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data1,$share);
        }
        array_push($my_data,$my_data1);
        array_push($my_data,$chart1_base[0]->base);
        // dd($my_data);
        
        //******************Chart 2****************
        $chart2_data=$this->get_frequency_table($project_code,'Q29',2,$filter);
        $chart2_base=$this->get_base($project_code,'Q29',2,$filter);
        // dd($chart2_data);
        $my_data2=array();
        $header2=array("Store type","Percentage");
        array_push($my_data2,$header2);

        foreach($chart2_data as $data)
        {
          $share=array($data->Label,(double)$data->Percentage);
          array_push($my_data2,$share);
        }
        array_push($my_data,$my_data2);
        array_push($my_data,$chart2_base[0]->base);



        // // dd($my_data);

        // //******************Chart 3****************
        // $chart3_data=$this->get_frequency_table($project_code,'Q231',2,$filter);
        // $chart3_base=$this->get_base($project_code,'Q231',2,$filter);
        // // dd($chart1_data);
        // $my_data3=array();
        // $header3=array("Category sale","Percentage");
        // array_push($my_data3,$header3);

        // foreach($chart3_data as $data)
        // {
        // $share=array($data->Label,(double)$data->Percentage);
        // array_push($my_data3,$share);
        // }
        // array_push($my_data,$my_data3);
        // array_push($my_data,$chart3_base[0]->base);

        // // dd($my_data);

        // //******************Chart 4****************
        // $chart4_data=$this->get_frequency_table($project_code,'Q232',2,$filter);
        // $chart4_base=$this->get_base($project_code,'Q232',2,$filter);
        // // dd($chart1_data);
        // $my_data4=array();
        // $header4=array("Category sale","Percentage");
        // array_push($my_data4,$header4);

        // foreach($chart4_data as $data)
        // {
        // $share=array($data->Label,(double)$data->Percentage);
        // array_push($my_data4,$share);
        // }
        // array_push($my_data,$my_data4);
        // array_push($my_data,$chart4_base[0]->base);

        // //******************Chart 5****************
        // $chart5_data=$this->get_frequency_table($project_code,'Q193',2,$filter);
        // $chart5_base=$this->get_base($project_code,'Q193',2,$filter);
        // // dd($chart1_data);
        // $my_data5=array();
        // $header5=array("Category sale","Percentage");
        // array_push($my_data5,$header5);

        // foreach($chart5_data as $data)
        // {
        // $share=array($data->Label,(double)$data->Percentage);
        // array_push($my_data5,$share);
        // }
        // array_push($my_data,$my_data5);
        // array_push($my_data,$chart5_base[0]->base);

        // dd($my_data);    
            return $my_data;
    }


    private function get_frequency_table($project_code,$qid,$qtype,$filter)
    {
        if($qtype==1)
        {
            if($filter=='')
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr_'.$project_code.'.Q16) AS Total, ROUND((COUNT(data_sr_'.$project_code.'.'.$qid.') * 100 / (SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS s FROM data_sr_'.$project_code.' WHERE '.$qid.'!="") ), 2) AS Percentage 
                FROM data_sr_'.$project_code.' INNER JOIN attributes_'.$project_code.' AS attributes ON data_sr_'.$project_code.'.Q16 = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND data_sr_'.$project_code.'.'.$qid.'!="" GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            }
            else
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT(data_sr_'.$project_code.'.Q16) AS Total, ROUND((COUNT(data_sr_'.$project_code.'.'.$qid.') * 100 / (SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS s FROM data_sr_'.$project_code.' WHERE '.$qid.'!="" AND '.$filter.') ), 2) AS Percentage 
                FROM data_sr_'.$project_code.' INNER JOIN attributes_'.$project_code.' AS attributes ON data_sr_'.$project_code.'.Q16 = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND data_sr_'.$project_code.'.'.$qid.'!="" AND '.$filter.' GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            }
            return $db_result;
        }
        else if($qtype==2)
        {
            if($filter=='')
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT('.$qid.'_'.$project_code.'.response) AS Total, ROUND((COUNT('.$qid.'_'.$project_code.'.response) * 100 / (SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS s FROM '.$qid.'_'.$project_code.') ), 2) AS Percentage 
                FROM '.$qid.'_'.$project_code.' INNER JOIN attributes_'.$project_code.' as attributes ON '.$qid.'_'.$project_code.'.response = attributes.attribute_value WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.'  GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            }
            else
            {
                $db_result = DB::select('SELECT attributes.attribute_label AS Label, COUNT('.$qid.'_'.$project_code.'.response) AS Total, ROUND((COUNT('.$qid.'_'.$project_code.'.response) * 100 / (SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS s FROM '.$qid.'_'.$project_code.' INNER JOIN data_sr_'.$project_code.' ON data_sr_'.$project_code.'.RespondentId = '.$qid.'_'.$project_code.'.RespondentId WHERE '.$filter.') ), 2) AS Percentage 
                FROM '.$qid.'_'.$project_code.' 
                INNER JOIN attributes_'.$project_code.' as attributes ON '.$qid.'_'.$project_code.'.response = attributes.attribute_value 
                INNER JOIN data_sr_'.$project_code.' ON data_sr_'.$project_code.'.RespondentId = '.$qid.'_'.$project_code.'.RespondentId
                WHERE attributes.qid = "'.$qid.'" AND attributes.project_code = '.$project_code.' AND '.$filter.' GROUP BY attributes.attribute_label ORDER BY attributes.attribute_order;');
            }
            return $db_result;
        }

    }

    private function get_base($project_code,$qid,$qtype,$filter)
    {
        if($qtype==1)
        {
            if($filter=='')
            {
                $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS base FROM data_sr_'.$project_code.' WHERE '.$qid.'!=""');
            }
            else
            {
                $base = DB::select('SELECT COUNT(data_sr_'.$project_code.'.'.$qid.') AS base FROM data_sr_'.$project_code.' WHERE '.$qid.'!="" AND '.$filter);
            }
            return $base;
        }
        else if($qtype==2)
        {
            if($filter=='')
            {
                $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base FROM '.$qid.'_'.$project_code);
            }
            else
            {
                $base=DB::select('SELECT COUNT(DISTINCT '.$qid.'_'.$project_code.'.RespondentId) AS base 
                FROM '.$qid.'_'.$project_code.'
                INNER JOIN data_sr_'.$project_code.' ON data_sr_'.$project_code.'.RespondentId = '.$qid.'_'.$project_code.'.RespondentId
                WHERE '.$filter);
            }

            return $base;
        }
    }
}

?>
