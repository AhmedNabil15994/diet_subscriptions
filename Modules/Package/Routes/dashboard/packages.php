<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::controller('PackageController')->prefix('packages')->as('packages.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::get('/deletes', 'deletes')->name('deletes');
        Route::get('/get-prices/{packageId}', 'getPrices')->name('get-prices');
        Route::get('/get-end-at/{priceId}/{startAt}', 'getEndAt')->name('get-end-at');
    });

    Route::controller('SubscriptionController')->prefix('subscriptions')->as('subscriptions.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');

        Route::get('/today-orders', 'todayOrders')->name('today_orders');
        Route::get('/today-orders/datatable', 'toDayDatatable')->name('today_orders.datatable');

        Route::get('/after-tomorrow-orders', 'afterTomorrowOrders')->name('after_tomorrow_orders');
        Route::get('/after-tomorrow-orders/datatable', 'afterTomorrowDatatable')->name('after_tomorrow_orders.datatable');

        Route::get('/deletes', 'deletes')->name('deletes');
        Route::get('/print', 'print')->name('print');

        Route::get('/getSubscriptionById/{id}', 'getSubscriptionById')->name('getSubscriptionById');
        Route::get('/permanentSuspension/{id}', 'permanentSuspension')->name('permanentSuspension');


    });
    Route::controller('SuspensionController')->prefix('suspensions')->as('suspensions.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::get('/deletes', 'deletes')->name('deletes');
//        Route::post('/{id}', 'update')->name('update');
    });
    Route::resources(
        [
            'subscriptions' => 'SubscriptionController',
            'packages'      => 'PackageController',
            'suspensions'   => 'SuspensionController'
        ],
    );
});
