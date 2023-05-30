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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/newbook', 'newbook')->name('newbook');
//Route::post('/savebook', 'App\Http\Controllers\HomeController@savebook');
Route::post('/savebook', 'App\Http\Controllers\HomeController@savebook')->name('savebook');
Route::get('/getbookid', 'App\Http\Controllers\HomeController@getbookid')->name('getbookid');
// confirm and remove
Route::post('/confirmbook', 'App\Http\Controllers\HomeController@confirmbook')->name('confirmbook');
Route::post('/deletebook', 'App\Http\Controllers\HomeController@deletebook')->name('deletebook');
