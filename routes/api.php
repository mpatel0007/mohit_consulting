<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('employee/list', 'App\Http\Controllers\Api\EmployeeDataController@list');

Route::post('Auth/SignUp', 'App\Http\Controllers\Api\RegistrationController@SignUp');
Route::post('Auth/SignIn', 'App\Http\Controllers\Api\RegistrationController@SignIn');

/***********Category */
Route::get('category/list', 'App\Http\Controllers\Api\CategoryController@list');
Route::get('category/all', 'App\Http\Controllers\Api\CategoryController@all');

/***********Sub Category */
Route::get('subcategory/list', 'App\Http\Controllers\Api\SubcategoryController@list');

/***********Skills */
Route::get('skill/list', 'App\Http\Controllers\Api\SkillController@list');

/***********Career Level */
Route::get('careerlevel/list', 'App\Http\Controllers\Api\CareerlevelController@list');

/***********degree level */
Route::get('degreelevel/list', 'App\Http\Controllers\Api\DegreelevelController@list');

/***********salary level */
Route::get('salary/list', 'App\Http\Controllers\Api\SalaryController@list');

/***********degree type */
Route::get('degreetype/list', 'App\Http\Controllers\Api\DegreetypeController@list');

/************* Country Api */
Route::get('country/list', 'App\Http\Controllers\Api\CountryController@list');

/************* State Api */
Route::get('state/list', 'App\Http\Controllers\Api\StateController@list');
Route::get('state/list/{country_id}', 'App\Http\Controllers\Api\StateController@list_country');

/************* City Api */
Route::get('city/list', 'App\Http\Controllers\Api\CityController@list');
Route::get('city/list/{state_id}', 'App\Http\Controllers\Api\CityController@list_state');
Route::post('user/detail/single', 'App\Http\Controllers\Api\UserController@profiledetails');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function() {

    /************* Job Api */
    Route::post('jobs/apply', 'App\Http\Controllers\Api\JobController@apply_job');
    Route::post('jobs/apply/remove', 'App\Http\Controllers\Api\JobController@apply_job_remove');
    Route::post('jobs/wishlist', 'App\Http\Controllers\Api\JobController@wishlist');
    Route::post('jobs/list', 'App\Http\Controllers\Api\JobController@list');
    Route::post('jobs/company_job_list', 'App\Http\Controllers\Api\JobController@company_job_list');
    Route::post('jobs/getjob', 'App\Http\Controllers\Api\JobController@getjobinfo');
    Route::post('jobs/manageapplicationslist', 'App\Http\Controllers\Api\JobController@manageapplicationslist');
    Route::post('jobs/getappliedmemberlist', 'App\Http\Controllers\Api\JobController@getappliedmemberlist');
    Route::post('jobs/appliedmember/update', 'App\Http\Controllers\Api\JobController@update_applied_member');
    Route::get('jobs/details/{job_id}', 'App\Http\Controllers\Api\JobController@details');
    Route::post('jobs/favlist', 'App\Http\Controllers\Api\JobController@favlist');
    Route::post('jobs/appliedlist', 'App\Http\Controllers\Api\JobController@appliedlist');
    Route::post('jobs/addjob', 'App\Http\Controllers\Api\JobController@addjob');
    Route::post('jobs/updatejob', 'App\Http\Controllers\Api\JobController@updatejob');
    
    /********* Teamup*/ 
    Route::get('teamname/list', 'App\Http\Controllers\Api\TeamnameController@list');
    Route::get('teamrequest/list', 'App\Http\Controllers\Api\TeamnameController@teamrequest_list');
    Route::post('teamrequest/remove', 'App\Http\Controllers\Api\TeamnameController@teamrequest_remove');
    Route::post('teamrequest/change', 'App\Http\Controllers\Api\TeamnameController@teamrequest_change');
    Route::get('teamjoined/list', 'App\Http\Controllers\Api\TeamnameController@teamjoined_list'); 
    Route::get('teamname/member/list/{team_id}', 'App\Http\Controllers\Api\TeamnameController@member_list');
    Route::post('teamname/user/list', 'App\Http\Controllers\Api\TeamnameController@get_users_list');
    Route::post('teamname/create', 'App\Http\Controllers\Api\TeamnameController@create');
    Route::post('teamname/edit_team_name', 'App\Http\Controllers\Api\TeamnameController@edit_team_name');
    Route::post('teamup/create/request', 'App\Http\Controllers\Api\TeamnameController@create_request');

    /********** Teamup task */
    Route::post('/team/task/create','App\Http\Controllers\Api\TeamnameController@create_team_task');
    Route::post('/team/task/edit','App\Http\Controllers\Api\TeamnameController@edit_team_task');
    Route::post('/team/task/update','App\Http\Controllers\Api\TeamnameController@team_task_update');
    Route::post('/assign/task','App\Http\Controllers\Api\TeamnameController@assign_task');
    Route::post('/remove/assign/task','App\Http\Controllers\Api\TeamnameController@remove_assign_task');
    Route::post('/members/task/list','App\Http\Controllers\Api\TeamnameController@members_task_list');


    /************* User(Candidate) Api */
    Route::post('user/changepassword', 'App\Http\Controllers\Api\UserController@changepassword');
    Route::get('user/profile', 'App\Http\Controllers\Api\UserController@profile');
    Route::post('user/profile_pic', 'App\Http\Controllers\Api\UserController@upload_profile_pic');
    
    Route::post('user/document/upload', 'App\Http\Controllers\Api\UserController@upload_document');
    Route::post('user/basic/update', 'App\Http\Controllers\Api\UserController@update_basic');
    Route::post('user/contact/update', 'App\Http\Controllers\Api\UserController@update_contact');
    Route::post('user/experiance/update', 'App\Http\Controllers\Api\UserController@update_experiance');
    Route::post('user/degreelevel/update', 'App\Http\Controllers\Api\UserController@update_degreelevel');
    Route::post('user/category/update', 'App\Http\Controllers\Api\UserController@update_category');
    Route::post('user/skill/update', 'App\Http\Controllers\Api\UserController@update_skill');
    Route::post('user/degreelevel/delete', 'App\Http\Controllers\Api\UserController@delete_degreelevel');
    Route::post('user/category/delete', 'App\Http\Controllers\Api\UserController@delete_category');
    Route::post('user/skill/delete', 'App\Http\Controllers\Api\UserController@delete_skill');
    
    /*******************Company Profile */
    Route::get('company/profile', 'App\Http\Controllers\Api\CompanyProfileController@info');
    Route::post('company/basic/update', 'App\Http\Controllers\Api\CompanyProfileController@update_basic');
    Route::post('company/location/update', 'App\Http\Controllers\Api\CompanyProfileController@update_location');
    Route::post('company/details/update', 'App\Http\Controllers\Api\CompanyProfileController@update_details');
    Route::post('company/profile_pic', 'App\Http\Controllers\Api\CompanyProfileController@upload_profile_pic');
});
