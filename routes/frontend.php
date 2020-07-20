<?php

Route::namespace('Web')->group(function () {
    Route::post('/git', 'GitController@index');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/users/{id}', 'UserController@show')->name('fo.users.show');
    Route::get('/streams/{id}', 'StreamController@show')->name('streams.show');
    Route::get('/videos/{slugAndId}.html', 'VideoController@show')->name('videos.show');
    Route::get('/videos/category/{slugAndId}.html', 'VideoController@categoryShow')->name('videos.categories.show');
    Route::get('/history.html', 'HistoryController@index')->name('history.index');

    Route::get('/legal/user/register/mentor.html', 'LegalController@mentorRegister')->name('legal.users.register.mentor');
    Route::get('/legal/user/register/learner.html', 'LegalController@learnerRegister')->name('legal.users.register.learner');

    Route::get('/user/register/mentor.html', 'UserController@mentorRegister')->name('user.register.mentor');
    Route::post('/user/register/mentor.html', 'UserController@doMentorRegister')->name('user.register.mentor.store');
    Route::get('/user/register/learner.html', 'UserController@learnerRegister')->name('user.register.learner');
    Route::post('/user/register/learner.html', 'UserController@doLearnerRegister')->name('user.register.learner.store');

    Route::get('/user/mentor/video/upload.html', 'MentorController@createVideo')->name('user.mentor.createVideo');
    Route::post('/user/mentor/video/upload.html', 'MentorController@storeVideo')->name('user.mentor.storeVideo');
    Route::get('/user/mentor/search.html', 'MentorController@search')->name('mentor.series.search');
});
