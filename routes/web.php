<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SurveyDataController;
use App\Http\Controllers\FrequencyController;
use App\Http\Controllers\CrossTableController;
use App\Http\Controllers\AdvancedAnalysisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchOperationController;
use App\Http\Controllers\SurveyFiltersController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserTypeController;

//Settings
use App\Http\Controllers\FilterParametersController;
use App\Http\Controllers\ShowingVariablesController;
use App\Http\Controllers\SupportInfoController;
use App\Http\Controllers\Settings\ProjectUsersController;

//Responsedent
use App\Http\Controllers\RespondentpanelController;
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

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/project/{id}/info', [HomeController::class, 'project_info'])->name('project_info');


//********************* Survey Data */
Route::get('/data_analysis/{id}/survey_data', [SurveyDataController::class, 'index'])->name('survey_data');
Route::get('/data_analysis/{id}/survey_data/get_filter_parameter', [SurveyDataController::class, 'get_filter_parameter'])->name('get_filter_parameter');
Route::post('/data_analysis/{id}/survey_data/get_survey_data', [SurveyDataController::class, 'get_survey_data'])->name('get_survey_data');
Route::post('/data_analysis/{id}/survey_data/update_data_status', [SurveyDataController::class, 'update_data_status'])->name('update_data_status');
Route::post('/data_analysis/{id}/survey_data/update_survey_data', [SurveyDataController::class, 'update_survey_data'])->name('update_survey_data');
Route::post('/data_analysis/{id}/survey_data/set_to_new_contact', [SurveyDataController::class, 'set_to_new_contact'])->name('set_to_new_contact');
Route::post('/data_analysis/{id}/survey_data/cati_report', [SurveyDataController::class, 'cati_report'])->name('cati_report');
Route::post('/data_analysis/{id}/survey_data/export_survey_data', [SurveyDataController::class, 'export_survey_data'])->name('export_survey_data');


//********************* Frequency */
Route::get('/data_analysis/{id}/frequency_table', [FrequencyController::class, 'index'])->name('frequency_table');
Route::get('/data_analysis/{id}/frequency_table/get_table_info', [FrequencyController::class, 'get_table_info'])->name('get_frequency_table_info');
Route::get('/data_analysis/{project_id}/frequency_table/{id}/get_freqyency_table', [FrequencyController::class, 'get_freqyency_table']);

//********************* Cross Table */
Route::get('/data_analysis/{id}/cross_table', [CrossTableController::class, 'index'])->name('cross_table');
Route::get('/data_analysis/{id}/cross_table/get_table_info', [CrossTableController::class, 'get_table_info'])->name('get_cross_table_info');
Route::post('/data_analysis/{id}/crossData',  [CrossTableController::class, 'get_cross_info']);
Route::post('/data_analysis/{id}/cross_table/get_filter_parameter',  [CrossTableController::class, 'get_filter_parameter']);

//********************* Advanced Analysis */
Route::get('/data_analysis/{id}/advanced_analysis', [AdvancedAnalysisController::class, 'index'])->name('advanced_analysis');


//********************* Dashboard */
Route::get('/data_analysis/{id}/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/data_analysis/{id}/dashboard/get_center_d1', [DashboardController::class, 'get_center_d1'])->name('get_center_d1');
Route::post('/data_analysis/{id}/dashboard/dashboard1', [DashboardController::class, 'dashboard1'])->name('dashboard1');

Route::get('/data_analysis/{id}/dashboard/get_center_d2', [DashboardController::class, 'get_center_d2'])->name('get_center_d2');
Route::post('/data_analysis/{id}/dashboard/dashboard2', [DashboardController::class, 'dashboard2'])->name('dashboard2');

Route::get('/data_analysis/{id}/dashboard/get_center_d3', [DashboardController::class, 'get_center_d3'])->name('get_center_d3');
Route::post('/data_analysis/{id}/dashboard/dashboard3', [DashboardController::class, 'dashboard3'])->name('dashboard3');

Route::get('/data_analysis/{id}/dashboard/get_center_d4', [DashboardController::class, 'get_center_d4'])->name('get_center_d4');
Route::post('/data_analysis/{id}/dashboard/dashboard4', [DashboardController::class, 'dashboard4'])->name('dashboard4');

//********************* Search Operation */
Route::get('/data_analysis/{id}/search_operation', [SearchOperationController::class, 'index'])->name('search_operation');
Route::get('/data_analysis/{id}/search_operation/get_all_parameter', [SearchOperationController::class, 'get_all_parameter'])->name('get_all_parameter');
Route::post('/data_analysis/{id}/search_operation/save_filter_parameter', [SearchOperationController::class, 'save_filter_parameter'])->name('save_filter_parameter');
Route::get('/data_analysis/{id}/search_operation/get_filter_parameter', [SearchOperationController::class, 'get_filter_parameter'])->name('get_filter_parameter');
Route::post('/data_analysis/{id}/search_operation/get_filter_data', [SearchOperationController::class, 'get_filter_data'])->name('get_filter_data');
Route::post('/data_analysis/{id}/search_operation/download_search_data', [SearchOperationController::class, 'download_search_data'])->name('download_search_data');


//********************* Settings */
Route::get('/settings/{id}/survey_filters/index', [SurveyFiltersController::class, 'index'])->name('filter_parameters_index');
Route::get('/settings/{id}/survey_filters/get_table_data', [SurveyFiltersController::class, 'get_table_data'])->name('get_table_data');
Route::get('/settings/{id}/survey_filters/get_variable_list', [SurveyFiltersController::class, 'get_variable_list'])->name('get_variable_list');
Route::post('/settings/{id}/survey_filters/set_variable_list', [SurveyFiltersController::class, 'set_variable_list'])->name('set_variable_list');
Route::get('/settings/{id}/{qid}/survey_filters/remove_variable', [SurveyFiltersController::class, 'remove_variable'])->name('remove_variable');

Route::get('/settings/{id}/filter_parameters/index', [FilterParametersController::class, 'index'])->name('filter_parameters_index');
Route::get('/settings/{id}/filter_parameters/get_table_data', [FilterParametersController::class, 'get_table_data'])->name('get_table_data');
Route::get('/settings/{id}/filter_parameters/get_variable_list', [FilterParametersController::class, 'get_variable_list'])->name('get_variable_list');
Route::post('/settings/{id}/filter_parameters/set_variable_list', [FilterParametersController::class, 'set_variable_list'])->name('set_variable_list');
Route::get('/settings/{id}/{qid}/filter_parameters/remove_variable', [FilterParametersController::class, 'remove_variable'])->name('remove_variable');

Route::get('/settings/{id}/set_variables/index', [ShowingVariablesController::class, 'index'])->name('set_variables_index');
Route::get('/settings/{id}/set_variables/get_table_data', [ShowingVariablesController::class, 'get_table_data'])->name('get_table_data');
Route::get('/settings/{id}/set_variables/get_variable_list', [ShowingVariablesController::class, 'get_variable_list'])->name('get_variable_list');
Route::post('/settings/{id}/set_variables/set_variable_list', [ShowingVariablesController::class, 'set_variable_list'])->name('set_variable_list');
Route::get('/settings/{id}/{qid}/set_variables/remove_variable', [ShowingVariablesController::class, 'remove_variable'])->name('remove_variable');


// **** User ****
Route::get('/user',[AdminController::class,'index'])->name('user_settings');
Route::get('/user/{id}/edit',[AdminController::class,'edit'])->name('edit_user');
Route::post('/user/{id}/update',[AdminController::class,'update'])->name('update_user');

Route::get('/user/change-password/index', [AdminController::class, 'change_password_index'])->name('change_password_index');
Route::get('/user/change-password', [AdminController::class, 'change_password'])->name('change_password');
Route::get('/user/{id}/reset_password/index', [AdminController::class, 'reset_password_index'])->name('reset_password_index');
Route::post('/user/reset_password', [AdminController::class, 'reset_password'])->name('reset_password');


//**** User Type */
Route::get('/user_type/index',[UserTypeController::class,'index'])->name('user_type_index');
Route::get('/user_type/get_user_type',[UserTypeController::class,'get_user_type'])->name('get_user_type');

//********************* User Role */

Route::get('/admin/user_role/index', [UserRoleController::class, 'index']);
Route::get('/admin/user_role/get_user_data', [UserRoleController::class, 'get_user_data'])->name('get_user_data');
Route::get('/admin/{user_id}/user_role/get_user_role', [UserRoleController::class, 'get_user_role'])->name('get_user_role');
Route::post('/admin/{user_id}/user_role/save_user_role', [UserRoleController::class, 'save_user_role'])->name('save_user_role');


//***************** Support Info */

Route::get('/settings/{id}/index', [SupportInfoController::class, 'index']);
Route::get('/settings/{id}/get_support_info', [SupportInfoController::class, 'get_support_info'])->name('get_support_info');

//***************** Project Users */
Route::get('/settings/{id}/project_users/index', [ProjectUsersController::class, 'index']);
Route::get('/settings/{id}/project_users/get_project_info', [ProjectUsersController::class,'get_project_info'])->name('get_project_info');
Route::get('/settings/{id}/project_users/get_project_user_info', [ProjectUsersController::class,'get_project_user_info'])->name('get_project_user_info');
Route::get('/settings/{id}/project_users/get_users', [ProjectUsersController::class,'get_users'])->name('get_users');
Route::post('/settings/project_users/assign_users', [ProjectUsersController::class,'assign_users'])->name('assign_users');
Route::get('/settings/{id}/project_users/delete_project_user', [ProjectUsersController::class,'delete_project_user'])->name('delete_project_user');

//*****************************Respondent Panel selection*/
Route::get('/resp_panel/{id}/panel_selection',[RespondentpanelController::class, 'index'])->name('panelindex');
Route::get('/resp_panel/search_operation/get_all_parameter',[RespondentpanelController::class, 'get_all_parameter']);
Route::post('/resp_panel/save_filter_data/save_data',[RespondentpanelController::class, 'save_data']);
Route::get('/resp_panel/resp_dropdown/resp_data',[RespondentpanelController::class, 'dropdown_data']);
Route::post('/resp_panel/filter_parameter/get_data',[RespondentpanelController::class, 'get_data']);
Route::get('/resp_panel/report_column/table_column',[RespondentpanelController::class, 'table_column']);
Route::post('/resp_panel/export_excel/excel_data',[RespondentpanelController::class, 'excel_data']);
//*****************************Respondent Panel setting*/
Route::get('/resp_panel/{id}/panel_setting',[RespondentpanelController::class, 'index_setting'])->name('panel_setting');
Route::get('/resp_panel/set_column/all_column',[RespondentpanelController::class, 'get_column']);
Route::post('/resp_panel/set_column/save_column',[RespondentpanelController::class, 'save_column']);
Route::get('/resp_panel/set_column/tableshow_column',[RespondentpanelController::class, 'tableshow_column']);
Route::post('/resp_panel/{id}/remove_column',[RespondentpanelController::class, 'remove_column']);


?>