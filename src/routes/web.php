<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers')
->group(function() {
    Route::get('/', 'IndexController@index')->name('home');

    Route::match(
        ['get', 'post'],
        '/upload', 
        'UploadController@index'
    )->name('upload');
});
