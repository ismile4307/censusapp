<?php

namespace App\Exports;

//use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

use DB;


class SurveyDataExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public $myQuery;

    public function __construct($myQuery)
    {
        $this->myQuery=$myQuery;
        // dd( $this->myQuery);
    }

    public function collection()
    {
        // return Project::all();
        $result=DB::select($this->myQuery);
        return collect($result);
    }

    public function headings(): array
    {
        // $project=Project::all();
        //$result=DB::select($this->myQuery.' LIMIT 1 ;');

        $result=DB::select($this->myQuery);
        
        $attributes = array_keys((array)$result[0]);
        // return ["your", "headings", "here"];
        // dd($attributes);


        return $attributes;
    }

    public function title(): string
    {
        return 'Search Report';
    }
}