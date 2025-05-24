<?php
//Dont Push this file
Route::group(['prefix' => 'transactions'], function () {

  	Route::get('/paid' ,'TransactionController@index')
  	->name('dashboard.transactions.paid');
//    ->middleware(['permission:show_transactions']);

    Route::get('/pending' ,'TransactionController@index')
        ->name('dashboard.transactions.pending');
//        ->middleware(['permission:show_transactions']);

  	Route::get('datatable'	,'TransactionController@datatable')
  	->name('dashboard.transactions.datatable');
//  	->middleware(['permission:show_transactions']);

});
