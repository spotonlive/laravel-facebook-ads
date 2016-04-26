<?php

Route::group(['prefix' => 'fb-token', 'as' => 'fb-token.'], function () {
    // Inbox
    Route::get('/', [
        'as' => 'token',
        'uses' => 'LaravelFacebookAds\Http\Controllers\TokenController@index',
    ]);
});
