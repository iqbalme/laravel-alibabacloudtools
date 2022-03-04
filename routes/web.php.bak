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

Route::get('/gettoken', 'MainCtrl@obtain_token');
Route::post('/tts', 'MainCtrl@getTTS');
Route::get('/testts', 'MainCtrl@getTTS');
Route::get('/tts', 'MainCtrl@tesTTS');
Route::post('/products', 'ProductCtrl@productByName');
Route::post('/upload', 'ProductCtrl@imgUpload');
Route::get('/productsbyimg', 'ProductCtrl@productByPicture');
Route::get('/tesfungsi', 'App\Http\Controllers\ProductCtrl@tesfungsi');
Route::get('/tesfungsi2', 'App\Http\Controllers\ImageCtrl@tesfungsi');
Route::get('/teslagi', 'App\Http\Controllers\ImageCtrl@teslagi');
Route::get('/covid', 'CovidCtrl@getDataCovid');