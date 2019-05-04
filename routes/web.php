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

Route::get('/','TaskController@index');

Route::get('/registrar', function () {
    return view('custom.auth.register');    
})->name('registrar');

Route::get('/logar', function () {
    return view('custom.auth.login');    
})->name('logar');

Auth::routes();

Route::get('/home', 'TaskController@index')->name('home');

Route::post('/addtask','TaskController@store')->name('addtask');
Route::post('/update/{id}','TaskController@update')->name('update');
Route::post('/toggle-status/{id}','TaskController@toggle_status')->name('toggle-status');
Route::post('/delete/{id}','TaskController@delete')->name('delete');
