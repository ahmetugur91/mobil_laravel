<?php

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


Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');


    Route::resource('number', 'NumberController');
    Route::resource('process', 'ProcessController');

    Route::get('processNumber/{id}', 'ProcessController@processNumber')->name("processNumber");
    Route::post('processNumber/{id}', 'ProcessController@processNumberPost')->name("processNumber.post");
    Route::post('processNumberDelete/{id}', 'ProcessController@processNumberDeletePost')->name("processNumberDelete.post");

});

Route::get("api/getNumbers/{count}","ProcessController@getNumbers")->name("getNumbers");
Route::post("api/setNumbers","ProcessController@setNumbers")->name("setNumbers");
