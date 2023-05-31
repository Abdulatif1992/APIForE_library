<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\BookController;

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

Route::get('dashboard', [BookController::class, 'index']); 

Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::view('/newbook', 'newbook')->name('newbook');
//Route::post('/savebook', 'App\Http\Controllers\BookController@savebook');
Route::post('/savebook', 'App\Http\Controllers\BookController@savebook')->name('savebook');
Route::get('/getbookid', 'App\Http\Controllers\BookController@getbookid')->name('getbookid');
// confirm and remove
Route::post('/confirmbook', 'App\Http\Controllers\BookController@confirmbook')->name('confirmbook');
Route::post('/deletebook', 'App\Http\Controllers\BookController@deletebook')->name('deletebook');
