<?php

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('categories', 'CategoryController')->except(['show']);
    Route::resource('series', 'SeriesController')->except(['show']);
    Route::get('/series/search', 'SeriesController@search')->name('series.search');
    Route::resource('videos', 'VideoController')->except(['show']);
});
