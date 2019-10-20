<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Api version 1.0
 */
Route::group(['prefix' => 'v1', 'middleware' => ['XssSanitizer']], function ()
{
    Route::group(['prefix' => 'auth', 'as' => 'auth::'], function ()
    {
        Route::post('signin', 'Api\v1\AuthController@signIn')->name('signIn');
        Route::post('signup', 'Api\v1\AuthController@signUp')->name('signUp');
    });
    Route::group(['prefix' => 'advert', 'as' => 'advert::', 'middleware' => ['auth:api']], function ()
    {
        Route::get('/', 'Api\v1\AdvertController@index')->name('index');
        Route::get('/{id}', 'Api\v1\AdvertController@show')->name('show');
        Route::post('/', 'Api\v1\AdvertController@store')->name('store');
        Route::put('/{id}', 'Api\v1\AdvertController@update')->name('update');
        Route::delete('/{id}', 'Api\v1\AdvertController@destroy')->name('destroy');
    });
});
