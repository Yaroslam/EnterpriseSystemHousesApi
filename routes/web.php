<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\RealtorController;
use App\Http\Controllers\RequirementsController;
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


Route::prefix("/clients")->group(function () {
    Route::post("/load", [ClientController::class, 'loadFromFile']);
    Route::get("/getClientsProposal", [ClientController::class, "getClientsProposal"]);
    Route::get("/getClientsRequirements", [ClientController::class, "getClientsRequirements"]);
});

Route::prefix("/realtors")->group(function () {
    Route::post("/load", [RealtorController::class, 'loadFromFile']);
    Route::get("/get", [RealtorController::class, 'getById']);
    Route::get("/getRealtorProposal", [RealtorController::class, "getRealtorProposal"]);
    Route::get("/getRealtorRequirements", [RealtorController::class, "getRealtorRequirements"]);
});


Route::prefix("/apartment")->group(function (){
    Route::post("/load", [ApartmentController::class, 'loadFromFile']);
});

Route::prefix("/district")->group(function (){
    Route::post("/load", [DistrictController::class, 'loadFromFile']);
});

Route::prefix("houses")->group(function () {
    Route::post("/load", [HouseController::class, 'loadFromFile']);
});

Route::prefix("/lands")->group(function () {
    Route::post("/load", [LandController::class, 'loadFromFile']);
});

Route::prefix("/estate")->group(function () {
    Route::get("/getAllEstate", [EstateController::class, 'getAllEstate']);
    Route::get("/SearchByAddress", [EstateController::class, 'SearchEstateByAddress']);
    Route::get("/SearchByDistrict", [EstateController::class, 'SearchEstateByDistrict']);
});

Route::prefix("/proposal")->group(function (){
    Route::get("/getApartmentsProposal", [ProposalController::class, 'getApartmentsProposal']);
    Route::get("/getHousesProposal", [ProposalController::class, 'getHousesProposal']);
    Route::get("/getLandsProposal", [ProposalController::class, 'getLandsProposal']);
    Route::get("/delete", [ProposalController::class, 'deleteProposal']);
    Route::post("/create", [ProposalController::class, 'createProposal']);
    Route::post("/update", [ProposalController::class, 'updateProposal']);
    Route::post("/findProposalForRequirements", [ProposalController::class, 'findProposalForRequirements']);

});

Route::prefix("/requirements")->group(function (){
    Route::post("/createRequirement", [RequirementsController::class, "createRequirements"]);
    Route::post("/deleteRequirement", [RequirementsController::class, "deleteRequirements"]);
    Route::post("/editRequirement", [RequirementsController::class, "editRequirements"]);
    Route::post("/findRequirementForProposal", [RequirementsController::class, "findRequirementForProposal"]);
    Route::post("/createRequirement", [RequirementsController::class, "createRequirements"]);



});

