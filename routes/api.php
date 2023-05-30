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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/booksid', 'App\Http\Controllers\ApiController@books');
Route::post('/getbook/{book_id}', 'App\Http\Controllers\ApiController@getBook');
Route::post('/getbooks/{booksIdList}', 'App\Http\Controllers\ApiController@getBooks');

Route::get('/download/{filename}', 'App\Http\Controllers\ApiController@download');

