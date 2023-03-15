<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class AdvancedAnalysisController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        return view('data_analysis.advanced_analysis',['project'=>$project]);
    }
}

?>
