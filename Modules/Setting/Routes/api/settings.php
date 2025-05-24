<?php

Route::group(['prefix' => 'settings'], function () {

    Route::get('/'               , 'SettingController@settings')->name('api.settings.index');
    Route::get('currency/{code}' , 'SettingController@convertCurrency')->name('api.convert.currency');

});
