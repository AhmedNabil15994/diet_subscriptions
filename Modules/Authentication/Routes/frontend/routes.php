<?php

Route::group(['prefix' => 'register'], function () {
    // Show Register Form
    Route::get('/', 'RegisterController@show')
        ->name('frontend.auth.register')
        ->middleware('guest');
    // Submit Register
    Route::post('/', 'RegisterController@register')
        ->name('frontend.auth.register.post');
});
Route::group(['prefix' => 'verify', 'middleware' => 'auth'], function () {
    // Show Register Form
    Route::get('/', 'VerifyController@verify')
        ->name('frontend.auth.verify');
    Route::post('/', 'VerifyController@verified')
        ->name('frontend.auth.verify.post');
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'LoginController@showLogin')
        ->name('frontend.auth.login')
        ->middleware('guest');
    Route::post('/', 'LoginController@postLogin')
        ->name('frontend.auth.login.post');
});


Route::group(['prefix' => 'logout', 'middleware' => 'auth'], function () {
    Route::any('/', 'LoginController@logout')
        ->name('frontend.auth.logout');
});

Route::group(['prefix' => 'reset'], function () {

    // Show Forget Password Form
    Route::get('{token}', 'ResetPasswordController@resetPassword')
        ->name('frontend.password.reset')
        ->middleware('guest');

    // Send Forget Password Via Mail
    Route::post('/', 'ResetPasswordController@updatePassword')
        ->name('frontend.password.update');
});


Route::group(['prefix' => 'password'], function () {

    // Show Forget Password Form
    Route::get('forget', 'ForgotPasswordController@forgetPassword')
        ->name('frontend.auth.password.request')
        ->middleware('guest');

    // Send Forget Password Via Mail
    Route::post('forget', 'ForgotPasswordController@sendForgetPassword')
        ->name('frontend.auth.password.email');
});
