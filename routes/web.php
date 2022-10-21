<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\RealtorController;
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

Route::post("/clients/load", [ClientController::class, 'loadFromFile']);
Route::post("/realtors/load", [RealtorController::class, 'loadFromFile']);
Route::post("/apartment/load", [ApartmentController::class, 'loadFromFile']);
Route::post("/district/load", [DistrictController::class, 'loadFromFile']);
Route::post("/houses/load", [HouseController::class, 'loadFromFile']);
Route::post("/lands/load", [LandController::class, 'loadFromFile']);
Route::get("/estate/getAllEstate", [EstateController::class, 'getAllEstate']);
Route::get("/estate/SearchByAddress", [EstateController::class, 'SearchEstateByAddress']);
Route::get("/estate/SearchByDistrict", [EstateController::class, 'SearchEstateByDistrict']);
