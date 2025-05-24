<?php

use Modules\Page\Entities\Page;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('show/{slug}', function ($slug) {

        $page = Page::anyTranslation('slug', $slug)->first();
        if (!checkRouteLocale($page, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$page->slug]);
        }
        return view('page::frontend.pages.show', compact('page'));
    })->name('pages.show');
});
