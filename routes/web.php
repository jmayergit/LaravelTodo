<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('api/users', 'Api\UsersController@index');
Route::get('api/users/{user}', 'Api\UsersController@show');

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');

// Route::get('/todos', 'TodosController@index');
