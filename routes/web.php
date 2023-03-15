<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyDataController;
use App\Http\Controllers\FrequencyController;
use App\Http\Controllers\CrossTableController;
use App\Http\Controllers\AdvancedAnalysisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchOperationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/project/{id}/info', [HomeController::class, 'project_info'])->name('project_info');

Route::get('/data_analysis/{id}/survey_data', [SurveyDataController::class, 'index'])->name('survey_data');
Route::get('/data_analysis/{id}/get_survey_data', [SurveyDataController::class, 'get_survey_data'])->name('get_survey_data');



Route::get('/data_analysis/{id}/frequency_table', [FrequencyController::class, 'index'])->name('frequency_table');
Route::get('/data_analysis/{id}/frequency_table/get_table_info', [FrequencyController::class, 'get_table_info'])->name('get_frequency_table_info');
Route::get('/data_analysis/{project_id}/frequency_table/{id}/get_freqyency_table', [FrequencyController::class, 'get_freqyency_table']);


Route::get('/data_analysis/{id}/cross_table', [CrossTableController::class, 'index'])->name('cross_table');
Route::get('/data_analysis/{id}/cross_table/get_table_info', [CrossTableController::class, 'get_table_info'])->name('get_cross_table_info');
Route::post('/data_analysis/crossData',  [CrossTableController::class, 'get_cross_info']);

Route::get('/data_analysis/{id}/advanced_analysis', [AdvancedAnalysisController::class, 'index'])->name('advanced_analysis');
Route::get('/data_analysis/{id}/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/data_analysis/{id}/search_operation', [SearchOperationController::class, 'index'])->name('search_operation');
Route::get('/data_analysis/{id}/search_operation/get_all_parameter', [SearchOperationController::class, 'get_all_parameter'])->name('get_all_parameter');
Route::post('/data_analysis/{id}/search_operation/save_filter_parameter', [SearchOperationController::class, 'save_filter_parameter'])->name('save_filter_parameter');
Route::get('/data_analysis/{id}/search_operation/get_filter_parameter', [SearchOperationController::class, 'get_filter_parameter'])->name('get_filter_parameter');
Route::post('/data_analysis/{id}/search_operation/get_filter_data', [SearchOperationController::class, 'get_filter_data'])->name('get_filter_data');



Route::get('/settings/{id}/filter_parameters', [HomeController::class, 'filter_parameters'])->name('filter_parameters');



?>