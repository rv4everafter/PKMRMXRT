<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'HomeController@index')->name('index');
Route::get('contact', 'ContactController@index')->name('contact');
Route::get('grievance', 'ContactController@grievance')->name('grievance');
Route::get('opportunities', 'ContactController@opportunities')->name('opportunities');
Route::post('contact/send', 'ContactController@send')->name('contact.send');
Route::post('contact/sendgrievance', 'ContactController@sendGrievance')->name('contact.sendgrievance');

Route::get('enroller', 'HomeController@getEnroller')->name('getenroller');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
        Route::get('profile/newcode/{user}', 'ProfileController@newCode')->name('profile.newcode');
    });
});
