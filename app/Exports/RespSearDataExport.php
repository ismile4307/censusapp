<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

use DB;

class RespSearDataExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $bd_results, $excel_heading;
    
    public function __construct($db_results, $field_title)
    {
        $this->bd_results=$db_results;
        $this->excel_heading=$field_title;

        // dd($bd_results);
    }


    public function collection()
    {
        return collect($this->bd_results);   
    }

    public function headings(): array
    {
       $attributes=[];

       foreach($this->excel_heading as $heading){
            array_push($attributes, $heading);
       }

        return $attributes;
    }

    public function title(): string
    {
        return 'Respdent Report';
    }

}
