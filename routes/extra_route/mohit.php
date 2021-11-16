<?php
Route::group(['prefix' => ADMIN], function () {
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/dashboard', 'App\Http\Controllers\Admin\AdmindashboardController@index')->name('admin-dashboard');
        // user
        Route::get('/admin/new', 'App\Http\Controllers\Admin\AdminController@adminlist')->name('admin-admin');
        Route::post('/admin/add', 'App\Http\Controllers\Admin\AdminController@insertnewadmin')->name('admin-admin-add');
        Route::post('/admin/datatable', 'App\Http\Controllers\Admin\AdminController@getalladminList')->name('admin-admin-list');
        Route::post('/admin/delete', 'App\Http\Controllers\Admin\AdminController@deleteadmindata')->name('admin-admin-delete');
        Route::post('/admin/edit', 'App\Http\Controllers\Admin\AdminController@editadmindata')->name('admin-admin-edit');
        Route::get('/admin/emailcheck', 'App\Http\Controllers\Admin\AdminController@emailcheck')->name('admin-admin-emailcheck');

        // cms
        Route::get('/cms', 'App\Http\Controllers\Admin\CmsController@cmsform')->name('admin-cms-form');
        Route::post('/cms/add', 'App\Http\Controllers\Admin\CmsController@addcms')->name('admin-cms-add');
        Route::get('/cms/list', 'App\Http\Controllers\Admin\CmsController@cmslist')->name('admin-cms-list');
        Route::post('/cms/datatable', 'App\Http\Controllers\Admin\CmsController@cmslistdatatable')->name('admin-cms-datatable');
        Route::post('/cms/delete', 'App\Http\Controllers\Admin\CmsController@deletecmsdata')->name('admin-cms-delete');
        Route::get('/cms/edit/{id}', 'App\Http\Controllers\Admin\CmsController@editcmsdata')->name('admin-cms-edit');
        Route::any('/cms/checkslug', 'App\Http\Controllers\Admin\CmsController@checkslug')->name('admin-cms-checkslug');

        //Campaign Management 
        Route::get('/CampaignManagement', 'App\Http\Controllers\Admin\CampaignmanagementController@CampaignManagement')->name('admin-CampaignManagement');
        Route::post('/CampaignManagement/add', 'App\Http\Controllers\Admin\CampaignmanagementController@addCampaignManagement')->name('admin-CampaignManagement-add');
        Route::post('/CampaignManagement/datatable', 'App\Http\Controllers\Admin\CampaignmanagementController@CampaignManagementdatatable')->name('admin-CampaignManagement-datatable');
        Route::post('/CampaignManagement/delete', 'App\Http\Controllers\Admin\CampaignmanagementController@deleteCampaignManagementdata')->name('admin-CampaignManagement-delete');
        Route::post('/CampaignManagement/edit', 'App\Http\Controllers\Admin\CampaignmanagementController@editCampaignManagementdata')->name('admin-CampaignManagement-edit');

        //job skills
        Route::get('/jobskill', 'App\Http\Controllers\Admin\JobskillController@jobskill')->name('admin-jobskill');
        Route::post('/jobskill/add', 'App\Http\Controllers\Admin\JobskillController@addjobskill')->name('admin-jobskill-add');
        Route::post('/jobskill/datatable', 'App\Http\Controllers\Admin\JobskillController@jobskilldatatable')->name('admin-jobskill-datatable');
        Route::post('/jobskill/delete', 'App\Http\Controllers\Admin\JobskillController@deletejobskilldata')->name('admin-jobskill-delete');
        Route::post('/jobskill/edit', 'App\Http\Controllers\Admin\JobskillController@editjobskilldata')->name('admin-jobskill-edit');

        // Career Level
        Route::get('/careerlevel', 'App\Http\Controllers\Admin\CareerlevelController@Careerlevel')->name('admin-careerlevel');
        Route::post('/careerlevel/add', 'App\Http\Controllers\Admin\CareerlevelController@addCareerLevel')->name('admin-careerlevel-add');
        Route::post('/careerlevel/datatable', 'App\Http\Controllers\Admin\CareerlevelController@Careerlevel_datatable')->name('admin-careerlevel-datatable');
        Route::post('/careerlevel/delete', 'App\Http\Controllers\Admin\CareerlevelController@deleteCareerLevel')->name('admin-careerlevel-delete');
        Route::post('/careerlevel/edit', 'App\Http\Controllers\Admin\CareerlevelController@editCareerLevel')->name('admin-careerlevel-edit');
        Route::post('/jobs/getskill/level', 'App\Http\Controllers\Admin\CareerlevelController@getSkillLevel')->name('admin-careerlevel-skill');

        // Degree level
        Route::get('/degreelevel', 'App\Http\Controllers\Admin\DegreelevelController@degreelevel')->name('admin-degreelevel');
        Route::post('/degreelevel/add', 'App\Http\Controllers\Admin\DegreelevelController@adddegreelevel')->name('admin-degreelevel-add');
        Route::post('/degreelevel/datatable', 'App\Http\Controllers\Admin\DegreelevelController@degreeleveldatatable')->name('admin-degreelevel-datatable');
        Route::post('/degreelevel/delete', 'App\Http\Controllers\Admin\DegreelevelController@deletedegreeleveldata')->name('admin-degreelevel-delete');
        Route::post('/degreelevel/edit', 'App\Http\Controllers\Admin\DegreelevelController@editdegreeleveldata')->name('admin-degreelevel-edit');

        // Salary
        Route::get('/salary', 'App\Http\Controllers\Admin\SalaryController@salary')->name('admin-salary');
        Route::post('/salary/add', 'App\Http\Controllers\Admin\SalaryController@addsalary')->name('admin-salary-add');
        Route::post('/salary/datatable', 'App\Http\Controllers\Admin\SalaryController@salarydatatable')->name('admin-salary-datatable');
        Route::post('/salary/delete', 'App\Http\Controllers\Admin\SalaryController@deletesalarydata')->name('admin-salary-delete');
        Route::post('/salary/edit', 'App\Http\Controllers\Admin\SalaryController@editsalarydata')->name('admin-salary-edit');

        // Degree Type
        Route::get('/degreetype', 'App\Http\Controllers\Admin\DegreetypeController@degreetype')->name('admin-degreetype');
        Route::post('/degreetype/add', 'App\Http\Controllers\Admin\DegreetypeController@adddegreetype')->name('admin-degreetype-add');
        Route::post('/degreetype/datatable', 'App\Http\Controllers\Admin\DegreetypeController@degreetypedatatable')->name('admin-degreetype-datatable');
        Route::post('/degreetype/delete', 'App\Http\Controllers\Admin\DegreetypeController@deletedegreetypedata')->name('admin-degreetype-delete');
        Route::post('/degreetype/edit', 'App\Http\Controllers\Admin\DegreetypeController@editdegreetypedata')->name('admin-degreetype-edit');

        //Companies
        Route::get('/companies', 'App\Http\Controllers\Admin\CompaniesController@companiesform')->name('admin-companies-form');
        Route::post('/companies/add', 'App\Http\Controllers\Admin\CompaniesController@addcompany')->name('admin-companies-add');
        Route::get('/companies/list', 'App\Http\Controllers\Admin\CompaniesController@companieslist')->name('admin-companies-list');
        Route::post('/companies/datatable', 'App\Http\Controllers\Admin\CompaniesController@companieslistdatatable')->name('admin-companies-datatable');
        Route::post('/companies/delete', 'App\Http\Controllers\Admin\CompaniesController@deletecompaniesdata')->name('admin-companies-delete');
        Route::get('/companies/edit/{id}', 'App\Http\Controllers\Admin\CompaniesController@editcompaniesdata')->name('admin-companies-edit');
        Route::get('/companies/emailcheck', 'App\Http\Controllers\Admin\CompaniesController@emailcheck')->name('admin-companies-emailcheck');

        // userprofile
        Route::get('/userprofile', 'App\Http\Controllers\Admin\UserprofileController@userprofileform')->name('admin-userprofile-form');
        Route::post('/userprofile/add', 'App\Http\Controllers\Admin\UserprofileController@adduserprofile')->name('admin-userprofile-add');
        Route::get('/userprofile/list', 'App\Http\Controllers\Admin\UserprofileController@userprofilelist')->name('admin-userprofile-list');
        Route::post('/userprofile/datatable', 'App\Http\Controllers\Admin\UserprofileController@userprofilelistdatatable')->name('admin-userprofile-datatable');
        Route::post('/userprofile/delete', 'App\Http\Controllers\Admin\UserprofileController@deleteuserprofiledata')->name('admin-userprofile-delete');
        Route::get('/userprofile/edit/{id}', 'App\Http\Controllers\Admin\UserprofileController@edituserprofiledata')->name('admin-userprofile-edit');
        Route::get('/userprofile/emailcheck', 'App\Http\Controllers\Admin\UserprofileController@emailcheck')->name('admin-userprofile-emailcheck');

        // subscriptions
        Route::get('/userprofile/subscriptions/view/{id}', 'App\Http\Controllers\Admin\UserprofileController@subscriptions_view')->name('admin-subscriptions-view');
        Route::post('/userprofile/subscriptions/list', 'App\Http\Controllers\Admin\UserprofileController@subscriptions_list')->name('admin-subscriptions-list');
        Route::post('/userprofile/subscriptions/charge/list', 'App\Http\Controllers\Admin\UserprofileController@subscriptions_charge_list')->name('admin-subscriptions-charge-list');

        // download document
        Route::post('/userprofile/candidate/resume/download', 'App\Http\Controllers\Admin\UserprofileController@candidate_resume_dowload')->name('admin-candidate-resume-download');
        Route::post('/userprofile/candidate/coverletter/download', 'App\Http\Controllers\Admin\UserprofileController@candidate_coverletter_dowload')->name('admin-candidate-coverletter-download');
        Route::post('/userprofile/candidate/references/download', 'App\Http\Controllers\Admin\UserprofileController@candidate_references_dowload')->name('admin-candidate-references-download');

        // jobs
        Route::get('/jobs', 'App\Http\Controllers\Admin\JobsController@jobsform')->name('admin-jobs-form');
        Route::post('/jobs/add', 'App\Http\Controllers\Admin\JobsController@addjobs')->name('admin-jobs-add');
        Route::get('/jobs/list', 'App\Http\Controllers\Admin\JobsController@jobslist')->name('admin-jobs-list');
        Route::post('/jobs/datatable', 'App\Http\Controllers\Admin\JobsController@jobslistdatatable')->name('admin-jobs-datatable');
        Route::post('/jobs/delete', 'App\Http\Controllers\Admin\JobsController@deletejobsdata')->name('admin-jobs-delete');
        Route::get('/jobs/edit/{id}', 'App\Http\Controllers\Admin\JobsController@editjobsdata')->name('admin-jobs-edit');

        // contact_us
        Route::get('/contact_us', 'App\Http\Controllers\Admin\ContactController@index')->name('admin-contact-form');
        Route::post('/contact_us/datatable', 'App\Http\Controllers\Admin\ContactController@contactus_list')->name('admin-contact-datatable');
        Route::post('/contact_us/delete', 'App\Http\Controllers\Admin\ContactController@delete_contact')->name('admin-contact-delete');

        //blogs
        Route::get('/blogs', 'App\Http\Controllers\Admin\BlogsController@blogsform')->name('admin-blogs-form');
        Route::post('/blogs/add', 'App\Http\Controllers\Admin\BlogsController@addblog')->name('admin-blogs-add');
        Route::get('/blogs/list', 'App\Http\Controllers\Admin\BlogsController@blogslist')->name('admin-blogs-list');
        Route::post('/blogs/datatable', 'App\Http\Controllers\Admin\BlogsController@blogslistdatatable')->name('admin-blogs-datatable');
        Route::post('/blogs/delete', 'App\Http\Controllers\Admin\BlogsController@deleteblogsdata')->name('admin-blogs-delete');
        Route::get('/blogs/edit/{id}', 'App\Http\Controllers\Admin\BlogsController@editblogsdata')->name('admin-blogs-edit');

        // Email Template 
        Route::get('/emailtemplate', 'App\Http\Controllers\Admin\EmailtemplateController@emailtemplate')->name('admin-email-template');
        Route::post('/emailtemplate/add', 'App\Http\Controllers\Admin\EmailtemplateController@add_emailtemplate')->name('admin-email-template-add');
        Route::post('/emailtemplate/datatable', 'App\Http\Controllers\Admin\EmailtemplateController@emailtemplate_datatable')->name('admin-email-template-datatable');
        Route::post('/emailtemplate/edit', 'App\Http\Controllers\Admin\EmailtemplateController@edit_emailtemplate')->name('admin-email-template-edit');

        // Salary
        Route::get('/popular/research', 'App\Http\Controllers\Admin\PopularSearchController@popular_search')->name('admin-popular-search');
        Route::post('/popular/research/add', 'App\Http\Controllers\Admin\PopularSearchController@add_popular_search')->name('admin-popular-search-add');
        Route::post('/popular/research/datatable', 'App\Http\Controllers\Admin\PopularSearchController@popular_search_datatable')->name('admin-popular-search-datatable');
        Route::post('/popular/research/delete', 'App\Http\Controllers\Admin\PopularSearchController@delete_popular_searchdata')->name('admin-popular-search-delete');
        Route::post('/popular/research/edit', 'App\Http\Controllers\Admin\PopularSearchController@edit_popular_searchdata')->name('admin-popular-search-edit');
    });
});

// Front end 
//Route::get('/', 'App\Http\Controllers\Front_end\HomeController@index');
Route::get('/home', 'App\Http\Controllers\Front_end\HomeController@index')->name('front_end-home');

//login
Route::get('/signin', 'App\Http\Controllers\Front_end\SigninController@signin')->name('front_end-signin');
Route::post('/signin/add', 'App\Http\Controllers\Front_end\SigninController@loginuser')->name('front_end-signin-add');
Route::get('/active/account/{UserId}/{UserType}', 'App\Http\Controllers\Front_end\SigninController@active_account')->name('front_end-active-account');
Route::get('/resend/activation/view', 'App\Http\Controllers\Front_end\SigninController@resend_account_activation_view')->name('front_end-resend-account-active-view');
Route::post('/resend/activation/mail', 'App\Http\Controllers\Front_end\SigninController@resend_account_activation_mail')->name('front_end-resend-account-active-mail');

// team up action from mail
Route::get('/teamup/action', 'App\Http\Controllers\Front_end\TeamupController@team_up_action_view')->name('front_end-team_up_action');

// Route::get('/logout','App\Http\Controllers\Front_end\SigninController@logout')->name('front_end-logout');
Route::get('/blog/details/{blogId?}', 'App\Http\Controllers\Front_end\HomeController@blog_details')->name('front_end-blog_details');
//register 
Route::get('/signup', 'App\Http\Controllers\Front_end\SignupController@signup')->name('front_end-signup');

Route::post('/signup/add', 'App\Http\Controllers\Front_end\SignupController@addnewuser')->name('front_end-signup-add');
Route::get('/contact', 'App\Http\Controllers\Front_end\ContactController@index')->name('front_end-contact');
Route::post('/contact/send', 'App\Http\Controllers\Front_end\ContactController@sendcontact')->name('front_end-send-contact');

// forgot password
Route::get('/forgotpassword', 'App\Http\Controllers\Front_end\ForgotpasswordController@forgotpassword')->name('front_end-forgot-password');
Route::post('/forgotpassword/change', 'App\Http\Controllers\Front_end\ForgotpasswordController@changepassword')->name('front_end-change-password');
Route::get('/forgotpassword/newpassword/{hid}/{token}', 'App\Http\Controllers\Front_end\ForgotpasswordController@newpassword')->name('front_end-new-password');
Route::post('/forgotpassword/setnewpassword', 'App\Http\Controllers\Front_end\ForgotpasswordController@setnewpassword')->name('front_end-set-new-password');

Route::get('/candidate/profiles/{candidate_id}/{teamID?}', 'App\Http\Controllers\Front_end\JobsController@candidate_details_view')->name('front_end-candidate_details_view');
Route::get('/candidate/profile/resume/download/{c_id}', 'App\Http\Controllers\Front_end\JobsController@resume_dowload')->name('front_end-employer-candidate-resume-download');
Route::get('/candidate/profile/coverletter/download/{c_id}', 'App\Http\Controllers\Front_end\JobsController@coverletter_dowload')->name('front_end-employer-candidate-coverletter-download');
Route::get('/candidate/profile/references/download/{c_id}', 'App\Http\Controllers\Front_end\JobsController@references_dowload')->name('front_end-employer-candidate-references-download');
Route::get('/candidate/attachment/download/{c_id}/{job_id}', 'App\Http\Controllers\Front_end\JobsController@attachment_dowload')->name('front_end-candidate-attachment-download');

Route::post('/team/up/message/candidate', 'App\Http\Controllers\Front_end\TeamupController@team_request_message')->name('front_end-team-up-message-candidate');



// Route::group(['middleware' => ['auth:employers']],function(){ 
Route::get('/postjobs', 'App\Http\Controllers\Front_end\JobsController@postjobsform')->name('front_end-jobs-form');
Route::post('/jobs/post', 'App\Http\Controllers\Front_end\JobsController@postjobs')->name('front_end-post-jobs');
Route::get('/manage/job', 'App\Http\Controllers\Front_end\JobsController@managejobsview')->name('front_end-manage-jobs-view');
Route::post('/manage/jobs/list', 'App\Http\Controllers\Front_end\JobsController@managejobslist')->name('front_end-manage-jobs-list');
Route::post('/jobs/delete', 'App\Http\Controllers\Front_end\JobsController@deletejobs')->name('front_end-delete-jobs');
Route::get('/jobs/edit/{id}', 'App\Http\Controllers\Front_end\JobsController@editjobs')->name('front_end-jobs-edit');
Route::get('/employers/companyprofile', 'App\Http\Controllers\Front_end\ChangecompanyinfoController@companyprofile_view')->name('front_end-manage-companyprofile-view');
Route::post('/employers/companyprofile/proccess', 'App\Http\Controllers\Front_end\ChangecompanyinfoController@companyprofile_proccess')->name('front_end-employer-ompanyprofile');
Route::get('/employers/changepassword', 'App\Http\Controllers\Front_end\JobsController@changepasswordview')->name('front_end-changepassword-view');
Route::post('/employers/changepassword/proccess', 'App\Http\Controllers\Front_end\JobsController@changepasswordproccess')->name('front_end-employer-changepassword');
Route::post('/manage/applications/list', 'App\Http\Controllers\Front_end\JobsController@manageapplicationslist')->name('front_end-manage-applications-list');
Route::post('/jobs/getskill/level', 'App\Http\Controllers\Front_end\JobsController@getSkillLevel')->name('front_end-manage-careerlevel-skill');

// manage applications
Route::get('/employers/manage/applications', 'App\Http\Controllers\Front_end\JobsController@manageapplicationsview')->name('front_end-manage-applications-view');
Route::post('/employers/manage/applications/reject', 'App\Http\Controllers\Front_end\JobsController@manageapplication_reject')->name('front_end-manage-applications-reject');
Route::post('/employers/manage/applications/accept', 'App\Http\Controllers\Front_end\JobsController@manageapplication_accept')->name('front_end-manage-applications-accept');
Route::post('/application/reject/reason', 'App\Http\Controllers\Front_end\JobsController@application_reject_reason')->name('front_end-application-reject-reason');
Route::post('/get/reject/reason', 'App\Http\Controllers\Front_end\JobsController@getApplicationsRejectReason')->name('front_end-reject-reason');

//employers img logo upload 
Route::post('/employers/manageprofile/upload/image', 'App\Http\Controllers\Front_end\ChangecompanyinfoController@employers_profile_image')->name('front_end-employers_profile_image');


// Route::get('/candidate/profiles/{candidate_id}','App\Http\Controllers\Front_end\JobsController@candidate_details_view')->name('front_end-candidate_details_view');
//  download candidate resume
// Route::get('/candidate/profile/resume/download/{c_id}','App\Http\Controllers\Front_end\JobsController@resume_dowload')->name('front_end-employer-candidate-resume-download');
Route::get('/employers/packages', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_manage_packages_view')->name('front-end-employers_payment');
Route::get('/employers/payment/{id}', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_manage_payment_view')->name('front-end-employer_payment');

Route::post('/employeer-downgradepackage', 'App\Http\Controllers\Front_end\ManageprofileController@downgradePackage')->name('employeer-downgrade-package');

// });

Route::get('/jobs/findjobs/view/{Category_id?}', 'App\Http\Controllers\Front_end\FindjobsController@candidate_findjobs_view')->name('front_end-find-jobs-view');
Route::post('/jobs/findjobs', 'App\Http\Controllers\Front_end\FindjobsController@candidate_findjobs')->name('front_end-find-jobs');
Route::post('/jobs/findjobs/load', 'App\Http\Controllers\Front_end\FindjobsController@get_data_on_scroll')->name('front_end-find-jobs-load');

Route::get('/jobs/jobdetails/{job_id}', 'App\Http\Controllers\Front_end\FindjobsController@job_details_view')->name('front_end-job_details_view');
Route::post('/jobdetails', 'App\Http\Controllers\Front_end\FindjobsController@getJobDetails')->name('front_end-getJobDetails');


// cms page 
Route::get('/cms/{cms_slug}', 'App\Http\Controllers\Front_end\HomeController@new_cms_page');

Route::group(['middleware' => ['auth:candidate']], function () {
    // apply candidate jobs
    Route::post('/jobs/applied', 'App\Http\Controllers\Front_end\FindjobsController@candidate_appliedjobs')->name('front_end-applied-jobs');

    // manage candidate profile
    Route::post('/jobs/makefavourite', 'App\Http\Controllers\Front_end\FindjobsController@job_makefavourite')->name('front_end-job-makefavourite');
    Route::post('/jobs/removefavourite', 'App\Http\Controllers\Front_end\FindjobsController@job_removefavourite')->name('front_end-job-removefavourite');
    Route::get('/candidate/manageprofile', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_manage_profile_view')->name('front_end-candidate_manageprofile');
    Route::get('/candidate/favouritejobs', 'App\Http\Controllers\Front_end\ManageprofileController@favouritejobs_view')->name('front_end-candidate-favourite-jobs-view');
    Route::post('/candidate/favouritejobs/list', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_favouritejobs')->name('front_end-candidate-favouritejobs-list');
    Route::post('/candidate/manageprofile/upload/image', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_profile_image')->name('front_end-candidate_profile_image');

    // apply candidate jobs
    Route::get('/jobs/applied/{job_id}', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_applyjobs')->name('front_end-apply-jobs');

    // candidate applied job list
    Route::post('/candidate/appliedjobs', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_appliedjobs')->name('front_end-candidate_appliedjobs');
    Route::post('/candidate/appliedjobs/delete', 'App\Http\Controllers\Front_end\ManageprofileController@delete_appliedjobs')->name('front_end-delete-applied-jobs');

    // changepassword
    Route::get('/candidate/changepassword', 'App\Http\Controllers\Front_end\ManageprofileController@changepassword_view')->name('front_end-candidate-changepassword-view');
    Route::post('/candidate/changepassword/proccess', 'App\Http\Controllers\Front_end\ManageprofileController@changepassword_proccess')->name('front_end-candidate-changepassword-proccess');

    // change profile
    Route::get('/candidate/changeprofile', 'App\Http\Controllers\Front_end\ManageprofileController@change_profile_view')->name('front_end-candidate-changeprofile-view');
    Route::post('/candidate/changeprofile/proccess', 'App\Http\Controllers\Front_end\ManageprofileController@changeprofile_proccess')->name('front_end-candidate-changeprofile-proccess');

    // get candidate job skill and level
    Route::post('/candidate/getskill/level', 'App\Http\Controllers\Front_end\ManageprofileController@getSkillLevel')->name('front_end-candidate-careerlevel-skill');

    // payment 
    Route::get('/payment', 'App\Http\Controllers\Front_end\ManageprofileController@payment')->name('payment');

    // document
    Route::get('/candidate/document', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_view')->name('front_end-candidate-document-view');
    // resume upload and download
    Route::post('/candidate/document/upload/resume', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_upload_resume')->name('front_end-candidate-resume-upload');
    Route::get('/candidate/document/download/resume', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_dowload_resume')->name('front_end-candidate-resume-download');
    // cover letter upload and download
    Route::post('/candidate/document/upload/coverletter', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_upload_coverletter')->name('front_end-candidate-coverletter-upload');
    Route::get('/candidate/document/download/coverletter', 'App\Http\Controllers\Front_end\ManageprofileControll er@candidate_document_dowload_coverletter')->name('front_end-candidate-coverletter-download');
    // references upload and download
    Route::post('/candidate/document/upload/references', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_upload_references')->name('front_end-candidate-references-upload');
    Route::get('/candidate/document/download/references', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_document_dowload_references')->name('front_end-candidate-references-download');


    Route::get('/candidate/packages', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_manage_packages_view')->name('front_end-candidate_package');
    Route::get('/candidate/payment/{id}', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_manage_payment_view')->name('front-end-candidate_payment');

    // Team up         
    // Route::get('/candidate/teamup/list','App\Http\Controllers\Front_end\TeamupController@teamup_list_view')->name('front_end-candidate-teamup-list');
    // Route::post('/candidate/teamup/proccess','App\Http\Controllers\Front_end\TeamupController@teamup_proccess')->name('front_end-candidate-teamup-proccess');

    // Team up
    Route::get('/candidate/teamup/view', 'App\Http\Controllers\Front_end\TeamupController@teamup_list_view')->name('front_end-candidate-teamup-list-view');
    Route::post('/candidate/team/list', 'App\Http\Controllers\Front_end\TeamupController@team_list')->name('front_end-candidate-teamup-proccess');

    Route::get('/candidate/new/teamup/{team_id?}', 'App\Http\Controllers\Front_end\TeamupController@new_teamup')->name('front_end-candidate-new-teamup');
    Route::get('/candidate/teamup/searchcandidate/{searchCandidate?}', 'App\Http\Controllers\Front_end\TeamupController@new_teamup_search')->name('front_end-candidate-new-teamup-search');
    Route::post('/candidate/teamname/add', 'App\Http\Controllers\Front_end\TeamupController@add_team_name')->name('front_end-candidate-add-teamname');
    Route::post('/candidate/team/addmember', 'App\Http\Controllers\Front_end\TeamupController@team_addmember')->name('front_end-candidate-addmember');
    Route::get('/candidate/team/members/view/{team_id}', 'App\Http\Controllers\Front_end\TeamupController@team_members_list_view')->name('front_end-candidate-members-view');
    Route::post('/candidate/team/members/list', 'App\Http\Controllers\Front_end\TeamupController@team_members_list')->name('front_end-candidate-members-list');
    Route::post('/candidate/team/members/remove', 'App\Http\Controllers\Front_end\TeamupController@team_member_remove')->name('front_end-candidate-members-remove');
    // Route::get('/candidate/team/edit/{team_id}','App\Http\Controllers\Front_end\TeamupController@team_edit')->name('front_end-candidate-team-edit');
    Route::post('/candidate/team/edit', 'App\Http\Controllers\Front_end\TeamupController@team_edit')->name('front_end-candidate-team-edit');
    Route::post('/candidate/team/delete', 'App\Http\Controllers\Front_end\TeamupController@team_delete')->name('front_end-candidate-team-delete');

    // Team Request
    Route::get('/candidate/team/request/view', 'App\Http\Controllers\Front_end\TeamupController@team_request_view')->name('front_end-candidate-team-request-view');
    Route::post('/candidate/team/request/list', 'App\Http\Controllers\Front_end\TeamupController@team_request_list')->name('front_end-candidate-team-request-list');
    Route::post('/candidate/team/request/accept', 'App\Http\Controllers\Front_end\TeamupController@team_request_accept')->name('front_end-candidate-team-request-accept');
    Route::post('/candidate/team/request/deny', 'App\Http\Controllers\Front_end\TeamupController@team_request_deny')->name('front_end-candidate-team-request-deny');


    // Task
    Route::post('/candidate/task/add', 'App\Http\Controllers\Front_end\TeamupController@add_new_task')->name('front_end-candidate-add-task');
    Route::get('/candidate/team/task/view/{team_id?}', 'App\Http\Controllers\Front_end\TeamupController@team_task_list_view')->name('front_end-candidate-team-task-view');
    Route::post('/candidate/team/task/list', 'App\Http\Controllers\Front_end\TeamupController@team_task_list')->name('front_end-candidate-team-task-list');
    Route::post('/candidate/team/task/edit', 'App\Http\Controllers\Front_end\TeamupController@task_edit')->name('front_end-candidate-team-task-edit');
    Route::post('/candidate/team/task/delete', 'App\Http\Controllers\Front_end\TeamupController@task_delete')->name('front_end-candidate-team-task-delete');
    Route::post('/candidate/gave/task', 'App\Http\Controllers\Front_end\TeamupController@gave_task')->name('front_end-candidate-gave-task');
    Route::post('/candidate/task', 'App\Http\Controllers\Front_end\TeamupController@task_add_candidate')->name('front_end-candidate-task');
    Route::post('/candidate/task/remove', 'App\Http\Controllers\Front_end\TeamupController@task_remove_candidate')->name('front_end-candidate-task-remove');
    Route::post('/candidate/my/task', 'App\Http\Controllers\Front_end\TeamupController@candidate_task')->name('front_end-candidate-my-task');
    Route::post('/candidate/teammates/list', 'App\Http\Controllers\Front_end\TeamupController@my_teammates_list')->name('front_end-candidate-my-teammates-list');




    // joined team
    Route::get('/candidate/team/joined', 'App\Http\Controllers\Front_end\TeamupController@team_joined_view')->name('front_end-candidate-team-joined-view');
    Route::post('/candidate/team/joined/list', 'App\Http\Controllers\Front_end\TeamupController@team_joined_list')->name('front_end-candidate-team-joined-list');
    Route::post('/downgradepackage', 'App\Http\Controllers\Front_end\ManageprofileController@downgradePackage')->name('downgrade-package');
});

Route::post('/notification', 'App\Http\Controllers\HomeController@notification')->name('notification');
Route::post('/dopayment', 'App\Http\Controllers\Front_end\ManageprofileController@dopayment')->name('dopayment');

// teamp up request action from mail
Route::get('/candidate/team/request/action/deny/{candidateId}/{candidateTeamid}', 'App\Http\Controllers\Front_end\TeamupController@team_request_deny_mail')->name('front_end-candidate-team-request-deny-mail');
Route::get('/candidate/team/request/action/accept/{candidateId}/{candidateTeamid}', 'App\Http\Controllers\Front_end\TeamupController@team_request_accept_mail')->name('front_end-candidate-team-request-accept-mail');


Route::get('/employers/chat', 'App\Http\Controllers\Front_end\ManageprofileController@candidate_chat_view')->name('frontend-chatify');
