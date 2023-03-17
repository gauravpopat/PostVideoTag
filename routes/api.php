<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PostController::class)->prefix('post')->group(function(){
    Route::get('list/{id}','list');
    Route::post('create','create');
    Route::post('tag','tag');
    Route::post('update','update');
    Route::get('delete/{id}','delete');
});

Route::controller(VideoController::class)->prefix('video')->group(function(){
    Route::get('list/{id}','list');
    Route::post('create','create');
    Route::post('tag','tag');
    Route::post('update','update');
    Route::get('delete/{id}','delete');
});
