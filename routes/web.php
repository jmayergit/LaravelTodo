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

Route::get('/api/users', 'Api\UsersController@index');
Route::get('/api/users/{user}', 'Api\UsersController@show');
Route::post('/api/todos', 'Api\TodosController@store');
Route::put('/api/todos/multiple', 'Api\TodosController@updateMultiple');
Route::put('/api/todos/{todo}', 'Api\TodosController@update');
Route::delete('/api/todos/multiple', 'Api\TodosController@destroyMultiple');
Route::delete('/api/todos/{todo}', 'Api\TodosController@destroy');

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');

// Route::get('/todos', 'TodosController@index');
