<?php

Route::get('/messages', [
    'as' => 'api.list.messages',
    'uses' => 'MessageController@index'
]);

Route::post('/messages', [
    'as' => 'api.store.messages',
    'uses' => 'MessageController@store'
]);
