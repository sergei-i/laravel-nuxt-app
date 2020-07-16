<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::get('/user', 'AuthController@user');

Route::group(['prefix' => 'topics'], function () {
    Route::get('/', 'TopicController@index');
    Route::get('/{topic}', 'TopicController@show');
    Route::post('/', 'TopicController@store')->middleware('auth:api');
    Route::patch('/{topic}', 'TopicController@update')->middleware('auth:api');
    Route::delete('/{topic}', 'TopicController@destroy')->middleware('auth:api');

    Route::group(['prefix' => '{topic}/posts'], function () {
        Route::get('/{post}', 'PostController@show');
        Route::post('/', 'PostController@store')->middleware('auth:api');
        Route::patch('/{post}', 'PostController@update')->middleware('auth:api');
        Route::delete('/{post}', 'PostController@destroy')->middleware('auth:api');

        Route::group(['prefix' => '{post}/likes'], function () {
            Route::post('/', 'PostLikeController@store')->middleware('auth:api');
        });
    });
});
