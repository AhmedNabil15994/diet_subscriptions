<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {


    Route::get('areas/get-child-area-by-parent', 'AreaController@getChildAreaByParent')
        ->name('area.get_child_area_by_parent');
        
    Route::get('areas/datatable'	,'AreaController@datatable')
        ->name('areas.datatable');

    Route::get('countries/deletes'	,'AreaController@deletes')
        ->name('areas.deletes');

    Route::resource('areas','AreaController')->names('areas');

});
