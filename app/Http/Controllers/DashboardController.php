<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index($id)
    {
        $project=Project::find($id);
        return view('data_analysis.dashboard',['project'=>$project]);
    }
}

?>
