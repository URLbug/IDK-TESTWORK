<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers')
->group(function() {
    Route::match(
        ['get', 'post'], 
        '/', 
        'IndexController@index'
    )->name('home');

    Route::post(
        '/update',
        'IndexController@update'
    )->name('update');

    Route::match(
        ['get', 'post'],
        '/upload', 
        'UploadController@index'
    )->name('upload');

    Route::get('/api/v1/images', 'ApiController@index')
    ->name('api');
});
