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

Route::get('/gettoken', 'App\Http\Controllers\MainCtrl@obtain_token');
Route::post('/tts', 'App\Http\Controllers\MainCtrl@getTTS');
Route::get('/testts', 'App\Http\Controllers\MainCtrl@getTTS');
Route::get('/tts', 'App\Http\Controllers\MainCtrl@tesTTS');
Route::post('/products', 'App\Http\Controllers\ProductCtrl@productByName');
Route::post('/upload', 'App\Http\Controllers\ProductCtrl@imgUpload');
Route::get('/productsbyimg', 'App\Http\Controllers\ProductCtrl@productByPicture');
Route::get('/tesfungsi', 'App\Http\Controllers\ProductCtrl@tesfungsi');
Route::get('/tesfungsi2', 'App\Http\Controllers\ImageCtrl@tesfungsi');
Route::get('/teslagi', 'App\Http\Controllers\ImageCtrl@teslagi');
Route::get('/covid', 'App\Http\Controllers\CovidCtrl@getDataCovid');