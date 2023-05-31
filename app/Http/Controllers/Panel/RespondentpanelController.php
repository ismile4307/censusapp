<?php

namespace App\Http\Controllers\Panel;

use App\Classes\MyClass;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Exports\RespSearDataExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\Controller;


use DB;
use Auth;
use Str;

class RespondentpanelController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();

        return view('resp_panel.panel_selection',['project'=>$project,'activity'=>$user_activity]);
    }

    public function get_all_parameter()
    {
        $user_id = Auth::User()->id;

        $data = DB::select('SELECT * FROM resp_datafield');

        $parameter_data=DB::select('SELECT field_name FROM resp_filter_parameters WHERE user_id='.$user_id);

        $p_data = [];

        foreach($parameter_data as $para){
            array_push($p_data, $para->field_name);
        }

        return [$data, $p_data];
    }

    public function save_data(Request $response)
    {
        $user_id = Auth::User()->id;
        $parameter = $response->save_filter_parameter;
        

        DB::delete('DELETE FROM resp_filter_parameters WHERE user_id='.$user_id);

        for($i=0; $i<count($parameter); $i++){

            DB::insert('INSERT INTO resp_filter_parameters (user_id, field_name) values ('.$user_id.',"'.$parameter[$i].'")'); 

        }

        return $this->dropdown_data();

    }

    public function dropdown_data()
    {
        $user_id = Auth::User()->id;
        $db_results = DB::select('SELECT rfp.field_name, rdf.description FROM resp_filter_parameters as rfp INNER JOIN resp_datafield AS rdf ON rfp.field_name=rdf.field_name WHERE user_id='.$user_id);

        $field_name=[];
        $description=[];
        $dropdown_data=[];

        foreach($db_results as $result){
            array_push($field_name, $result->field_name);
            array_push($description, $result->description);
            array_push($dropdown_data, $this->get_dropdown_list($result->field_name));
        }


        return [$field_name, $description, $dropdown_data];
    }

    private function get_dropdown_list($field)
    {
        $db_results = DB::select('SELECT DISTINCT '.$field.' AS label FROM resp_panels');
        return $db_results;
    }

    public function get_data(Request $request)
    {
        $selected_filter_values=$request->selected_filter_values;
        $field_name=$request->field_nama;

        $table_column=$request->table_column;

        $column_name=[];

        foreach($table_column as $column){
            array_push($column_name, $column['column_name']);
        }
       
        $str_field_name=implode(", ", $column_name);

        //dd($str_field_name);

        $where = $this->get_where_syntax($selected_filter_values, $field_name);

        $db_results_total = DB::select(' SELECT count(id) as total FROM resp_panels WHERE '.$where. ' LIMIT 50');
        $db_results = DB::select(' SELECT '.$str_field_name.' FROM resp_panels WHERE '.$where. ' LIMIT 50');
        //dd(" SELECT ".$str_field_name." FROM resp_panels WHERE ".$where);

        if($db_results!==null){
            return [$db_results_total,$db_results]; 
        }else{
            return "Please try again";
        }
            
    }

    public function excel_data(Request $request)
    {
        $selected_values=$request->selected_filter_values;
        $filter_field=$request->field_nama;
        $table_column=$request->table_column;

        $field_name=[];
        $field_title=[];

        foreach($table_column as $column){
            array_push($field_name, $column['column_name']);
            array_push($field_title, $column['column_description']);
        }
       
        $str_field_name=implode(", ", $field_name);
        //dd($str_field_name);

        // json_encode($field_name);
       // $str_field_name = Str::substr($str_field_name, 1, Str::length($str_field_name)-2);
        
        $where = $this->get_where_syntax($selected_values, $filter_field);

        // dd((' SELECT '.$str_field_name.' FROM resp_panels WHERE '.$where));

       $db_results = DB::select(" SELECT ".$str_field_name." FROM resp_panels WHERE ".$where);

        //dd($db_results);

        ob_end_clean(); 
        ob_start();

        return Excel::download(new RespSearDataExport($db_results, $field_title), 'Respdent_data.xlsx');

        
    }

    private function get_where_syntax($field_values, $field_name)
    {
        $where="";

        $i=0;
        foreach($field_name as $cname){
            if($field_values[$i]!=0){
                if(count($field_values[$i])>0){
                    $where_or="(";
                    foreach($field_values[$i] as $value){
                        $where_or=$where_or.$cname."='".$value."' OR "; 
                    }
                    $where_or=Str::substr($where_or, 0, Str::length($where_or)-4).")";
                    $where=$where.$where_or." AND ";

                }
            }
            $i++;
        }
        if($where!=""){
            $where=Str::substr($where, 0, Str::length($where)-5);
        }

        return $where;

    }

    public function table_column()
    {
        $db_results = DB::select('SELECT column_name, column_description FROM resp_show_column');

        return $db_results;
    }


    // panel_Setting Start
    public function index_setting($id)
    {
        $project=Project::find($id);
        $my_class=new MyClass();
        $user_activity=$my_class->get_user_role();

        return view('resp_panel.panel_setting',['project'=>$project,'activity'=>$user_activity]);

    }

    public function get_column()
    {
        $data = DB::select('SELECT id, field_name, description FROM resp_datafield WHERE field_name NOT IN (SELECT column_name FROM resp_show_column)');
        
        return $data;
    }

    public function save_column(Request $resquest)
    {
        $column_id=$resquest->selectedColumn_id;

        if(count($column_id)>0){
            foreach($column_id as $id){
                DB::select('INSERT INTO resp_show_column (column_name, column_description, status) SELECT field_name, description, 1 FROM resp_datafield WHERE id='.$id);
            }
        }
        return "Inserted successfully";
    }

    public function tableshow_column()
    {
        $db_results = DB::select('SELECT * FROM resp_show_column');

        return $db_results;

    }

    public function remove_column($id)
    {
        DB::select('DELETE FROM resp_show_column WHERE id='.$id);

        return "deleted successfully";
    }
    
}


?>