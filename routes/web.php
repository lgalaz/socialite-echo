<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/login/facebook', [
    'as' => 'auth.facebook.login',
    'uses' => 'SocialAuthController@facebookLogin'
]);

Route::get('auth/logout', [
    'as' => 'auth.logout',
    'uses' => 'SocialAuthController@logout'
]);

