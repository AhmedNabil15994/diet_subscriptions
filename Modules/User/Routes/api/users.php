<?php

Route::group(['prefix' => 'user','middleware' => 'auth:api'], function () {

    Route::get('profile'            , 'UserController@profile')->name('api.users.profile');
    Route::put('profile'            , 'UserController@updateProfile')->name('api.users.profile');
    Route::put('change-password'    , 'UserController@changePassword')->name('api.users.change.password');

});


Route::group(['prefix' => 'company','middleware' => 'auth:api'], function () {

    Route::get('profile'            , 'CompanyController@profile')->name('api.companys.profile');
    Route::put('profile'            , 'CompanyController@updateProfile')->name('api.companys.profile');
    Route::put('change-password'    , 'CompanyController@changePassword')->name('api.companys.change.password');

});
