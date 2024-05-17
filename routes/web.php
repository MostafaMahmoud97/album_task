<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AlbumController;
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
    return view('index');
});


Route::group(["prefix" => "albums"],function (){
    Route::get("/",[AlbumController::class,"index"])->name("album.index");
    Route::get("/create",[AlbumController::class,"create"])->name("album.create");
    Route::post("/store",[AlbumController::class,"store"])->name("album.store");
    Route::get("/show/{id}",[AlbumController::class,"show"])->name("album.show");
    Route::get("/delete/{id}",[AlbumController::class,"destroy"])->name("album.delete");
    Route::post("/move/{id}",[AlbumController::class,"movePictures"])->name("album.move");
    Route::get("/edit/{id}",[AlbumController::class,"edit"])->name("album.edit");
    Route::post("/update/{id}",[AlbumController::class,"update"])->name("album.update");
});

