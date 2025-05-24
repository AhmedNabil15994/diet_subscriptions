<?php

Route::controller('UserController')->prefix('/profile')->name('frontend.profile.')->group(function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'update')->name('update');
});
Route::controller('SubscriptionController')->prefix('/subscriptions')->name('frontend.subscriptions.')->group(function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'renew')->name('renew');
});
