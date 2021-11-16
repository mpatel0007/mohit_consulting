<?php
Route::group(['prefix' => ADMIN], function() {
    Route::group(['middleware' => ['auth:admin']], function () { 
        // role
        Route::get('/role','App\Http\Controllers\Admin\RoleController@index')->name('role');
        Route::post('/role/add','App\Http\Controllers\Admin\RoleController@insertrole')->name('admin-role-add');
        Route::post('/role/datatable','App\Http\Controllers\Admin\RoleController@read_data')->name('admin-role-datatable');
        Route::post('/role/delete','App\Http\Controllers\Admin\RoleController@delete_role')->name('admin-role-delete');
        Route::post('/role/edit','App\Http\Controllers\Admin\RoleController@edit_role')->name('admin-role-edit');

        // Testimonials
        Route::any('/testimonials','App\Http\Controllers\Admin\TestimonialsController@index')->name('testimonials');
        Route::post('/testimonial/add','App\Http\Controllers\Admin\TestimonialsController@insert_testimonial')->name('admin-testimonial-add');
        Route::post('/testimonial/datatable','App\Http\Controllers\Admin\TestimonialsController@read_testimonial')->name('admin-testimonial-datatable');
        Route::post('/testimonial/delete','App\Http\Controllers\Admin\TestimonialsController@delete_testimonial')->name('admin-testimonial-delete');
        Route::post('/testimonial/edit','App\Http\Controllers\Admin\TestimonialsController@edit_testimonial')->name('admin-testimonial-edit');

        // Faqs
        Route::get('/faqs','App\Http\Controllers\Admin\FaqsController@index')->name('faqs');
        Route::post('/faqs/add','App\Http\Controllers\Admin\FaqsController@insert_faqs')->name('admin-faqs-add');
        Route::post('/faqs/datatable','App\Http\Controllers\Admin\FaqsController@read_faqs')->name('admin-faqs-datatable');
        Route::post('/faqs/delete','App\Http\Controllers\Admin\FaqsController@delete_faqs')->name('admin-faqs-delete');
        Route::post('/faqs/edit','App\Http\Controllers\Admin\FaqsController@edit_faqs')->name('admin-faqs-edit');

        // Industries
        Route::get('/industries','App\Http\Controllers\Admin\IndustriesController@index')->name('industries');
        Route::post('/industries/add','App\Http\Controllers\Admin\IndustriesController@insert_industries')->name('admin-industries-add');
        Route::post('/industries/datatable','App\Http\Controllers\Admin\IndustriesController@read_industries')->name('admin-industries-datatable');
        Route::post('/industries/delete','App\Http\Controllers\Admin\IndustriesController@delete_industries')->name('admin-industries-delete');
        Route::post('/industries/edit','App\Http\Controllers\Admin\IndustriesController@edit_industries')->name('admin-industries-edit');

        // Country
        Route::get('/country','App\Http\Controllers\Admin\CountryController@index')->name('country');
        Route::post('/country/add','App\Http\Controllers\Admin\CountryController@insert_country')->name('admin-country-add');
        Route::post('/country/datatable','App\Http\Controllers\Admin\CountryController@read_country')->name('admin-country-datatable');
        Route::post('/country/delete','App\Http\Controllers\Admin\CountryController@delete_country')->name('admin-country-delete');
        Route::post('/country/edit','App\Http\Controllers\Admin\CountryController@edit_country')->name('admin-country-edit');

        // State
        Route::get('/state','App\Http\Controllers\Admin\StateController@index')->name('state');
        Route::post('/state/add','App\Http\Controllers\Admin\StateController@insert_state')->name('admin-state-add');
        Route::post('/state/datatable','App\Http\Controllers\Admin\StateController@read_state')->name('admin-state-datatable');
        Route::post('/state/delete','App\Http\Controllers\Admin\StateController@delete_state')->name('admin-state-delete');
        Route::post('/state/edit','App\Http\Controllers\Admin\StateController@edit_state')->name('admin-state-edit');

        // City
        Route::get('/city','App\Http\Controllers\Admin\CityController@index')->name('city');
        Route::post('/city/add','App\Http\Controllers\Admin\CityController@insert_city')->name('admin-city-add');
        Route::post('/city/datatable','App\Http\Controllers\Admin\CityController@read_city')->name('admin-city-datatable');
        Route::post('/city/delete','App\Http\Controllers\Admin\CityController@delete_city')->name('admin-city-delete');
        Route::post('/city/edit','App\Http\Controllers\Admin\CityController@edit_city')->name('admin-city-edit');

        // Functional Area
        Route::get('/functional_area','App\Http\Controllers\Admin\Functional_areaController@index')->name('functional_area');
        Route::post('/functional_area/add','App\Http\Controllers\Admin\Functional_areaController@insert_functional_area')->name('admin-functional_area-add');
        Route::post('/functional_area/datatable','App\Http\Controllers\Admin\Functional_areaController@read_functional_area')->name('admin-functional_area-datatable');
        Route::post('/functional_area/delete','App\Http\Controllers\Admin\Functional_areaController@delete_functional_area')->name('admin-functional_area-delete');
        Route::post('/functional_area/edit','App\Http\Controllers\Admin\Functional_areaController@edit_functional_area')->name('admin-functional_area-edit');

        // Package
        Route::get('/package','App\Http\Controllers\Admin\PackageController@index')->name('package');
        Route::post('/package/add','App\Http\Controllers\Admin\PackageController@insert_package')->name('admin-package-add');
        Route::post('/package/datatable','App\Http\Controllers\Admin\PackageController@read_package')->name('admin-package-datatable');
        Route::post('/package/delete','App\Http\Controllers\Admin\PackageController@delete_package')->name('admin-package-delete');
        Route::post('/package/edit','App\Http\Controllers\Admin\PackageController@edit_package')->name('admin-package-edit');

        // Major Subject
        Route::get('/major_subject','App\Http\Controllers\Admin\MajorsubjectController@index')->name('major_subject');
        Route::post('/major_subject/add','App\Http\Controllers\Admin\MajorsubjectController@insert_major_subject')->name('admin-major_subject-add');
        Route::post('/major_subject/datatable','App\Http\Controllers\Admin\MajorsubjectController@read_major_subject')->name('admin-major_subject-datatable');
        Route::post('/major_subject/delete','App\Http\Controllers\Admin\MajorsubjectController@delete_major_subject')->name('admin-major_subject-delete');
        Route::post('/major_subject/edit','App\Http\Controllers\Admin\MajorsubjectController@edit_major_subject')->name('admin-major_subject-edit');

        // Settings
        Route::get('/setting','App\Http\Controllers\Admin\SettingController@index')->name('setting');
        Route::post('/setting/add','App\Http\Controllers\Admin\SettingController@save_settings')->name('admin-setting-add');
        Route::any('/setting/fillup/{id}','App\Http\Controllers\Admin\SettingController@fillupdata')->name('admin-setting-fillup');




















    });
});
//Front-End


