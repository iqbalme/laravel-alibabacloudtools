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