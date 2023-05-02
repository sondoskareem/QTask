<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/register', 'App\Http\Controllers\AuthController@register');
Route::post('auth/login', 'App\Http\Controllers\AuthController@login');
Route::post('auth/register/emp', 'App\Http\Controllers\EmployeeGroupController@store');



Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
        Route::get('me', 'App\Http\Controllers\AuthController@me');
    });

    Route::group(['prefix' => 'group'], function ($router) {
        Route::post('/', 'App\Http\Controllers\GroupController@store');
    });

    Route::group(['prefix' => 'permit'], function ($router) {
        Route::post('/', 'App\Http\Controllers\PermitController@store');
        Route::get('/', 'App\Http\Controllers\PermitController@index');
        Route::put('/', 'App\Http\Controllers\PermitController@edit');
    });

});
