<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataLinkExport;

use DB;
use Auth;
use Str;


class DownloadController extends Controller
{
    public function index(){

        $projects=DB::select('SELECT * FROM projects WHERE Status=1');

        return view('admin.download',['projects'=>$projects]);
    }

    public function download(Request $request){
        
        $project_code=$request->input('project_code');
        $table_type=$request->input('table_type');
        $file_name="";
        if($table_type==1){
            $query='SELECT dr.*FROM `data_sr_'.$project_code.'` as dr LIMIT 25000 OFFSET 25000;';
            $file_name='data_sr_'.$project_code.'.xlsx';
        }else if ($table_type==2){
            $query='SELECT sl.* FROM survey_links_'.$project_code.' as sl';
            $file_name='survey_link_'.$project_code.'.xlsx';
        }else if($table_type==3){
            $query='SELECT dr.*, sl.survey_link,sl.interviewed_by,sl.interview_date,sl.status FROM `data_sr_'.$project_code.'` as dr
            INNER JOIN survey_links_'.$project_code.' as sl ON dr.RespondentId=sl.RespondentId;';
            $file_name='data_link_'.$project_code.'.xlsx';
        }


        return Excel::download(new DataLinkExport($query), $file_name);
        




    }
}
