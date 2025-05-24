<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'contacts'], function () {
    Route::get('/', 'ContactController@index')->name('frontend.contacts.index');
    Route::post('/', 'ContactController@sendContact')->name('frontend.contacts.post');
});

