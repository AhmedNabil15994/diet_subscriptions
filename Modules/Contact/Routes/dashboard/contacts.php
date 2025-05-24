<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::get('contacts/datatable', 'ContactController@datatable')
        ->name('contacts.datatable');

    Route::get('contacts/deletes', 'ContactController@deletes')
        ->name('contacts.deletes');
    Route::resource('contacts', 'ContactController')->names('contacts');
});
