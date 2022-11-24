<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DealController;
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
//    Route::post("/load", [ClientController::class, 'loadFromFile']);
    Route::get("/getClientsProposal", [ClientController::class, "getClientsProposal"]);
    Route::get("/getClientsRequirements", [ClientController::class, "getClientsRequirements"]);
//    Route::get("/findClient", [ClientController::class, "findClient"]);
//    Route::get("/getAllClients", [ClientController::class, "getAllClients"]);
    Route::post("/editClient", [ClientController::class, "editClient"]);
//    Route::get("/deleteClient", [ClientController::class, "deleteClient"]);
//    Route::post("/addClient", [ClientController::class, "addClient"]);
});

Route::prefix("/realtors")->group(function () {
    Route::post("/load", [RealtorController::class, 'loadFromFile']);
//    Route::post("/addRealtor", [RealtorController::class, 'addRealtor']);
//    Route::get("/deleteRealtor", [RealtorController::class, 'deleteRealtor']);
//    Route::post("/editRealtor", [RealtorController::class, 'editRealtor']);
//    Route::get("/getAllRealtors", [RealtorController::class, 'getAllRealtors']);
//    Route::get("/findRealtor", [RealtorController::class, 'findRealtor']);
//    Route::get("/getRealtor", [RealtorController::class, 'getById']);
    Route::get("/getRealtorProposal", [RealtorController::class, "getRealtorProposal"]);
    Route::get("/getRealtorRequirements", [RealtorController::class, "getRealtorRequirements"]);
});


Route::prefix("/apartment")->group(function (){
    Route::post("/load", [ApartmentController::class, 'loadFromFile']);
});

Route::prefix("/district")->group(function (){
    Route::post("/load", [DistrictController::class, 'loadFromFile']);
    Route::get("/getAll", [DistrictController::class, 'getAll']);
});

Route::prefix("houses")->group(function () {
    Route::post("/load", [HouseController::class, 'loadFromFile']);
});

Route::prefix("/lands")->group(function () {
    Route::post("/load", [LandController::class, 'loadFromFile']);
});

Route::prefix("/estate")->group(function () {
//    Route::get("/getAllEstate", [EstateController::class, 'getAllEstate']);
//    Route::get("/SearchByAddress", [EstateController::class, 'SearchEstateByAddress']);
//    Route::get("/SearchByDistrict", [EstateController::class, 'SearchEstateByDistrict']);
//    Route::post("/createEstate", [EstateController::class, 'createEstate']);
//    Route::get("/deleteEstate", [EstateController::class, 'deleteEstate']);
//    Route::post("/updateEstate", [EstateController::class, 'updateEstate']);
});

Route::prefix("/proposal")->group(function (){
//    Route::get("/getApartmentsProposal", [ProposalController::class, 'getApartmentsProposal']);
//    Route::get("/getHousesProposal", [ProposalController::class, 'getHousesProposal']);
//    Route::get("/getLandsProposal", [ProposalController::class, 'getLandsProposal']);
//    Route::get("/delete", [ProposalController::class, 'deleteProposal']);
//    Route::post("/create", [ProposalController::class, 'createProposal']);
    Route::post("/update", [ProposalController::class, 'updateProposal']);
    Route::get("/findProposalForRequirements", [ProposalController::class, 'findProposalForRequirements']);

});

Route::prefix("/requirements")->group(function (){
    Route::post("/createRequirement", [RequirementsController::class, "createRequirements"]);
    Route::get("/deleteRequirement", [RequirementsController::class, "deleteRequirements"]);
    Route::post("/editRequirement", [RequirementsController::class, "editRequirements"]);
    Route::get("/findRequirementForProposal", [RequirementsController::class, "findRequirementForProposal"]);
});

Route::prefix("/deal")->group(function (){
    Route::post("/createDeal", [DealController::class, "createDeal"]);
    Route::post('editDeal', [DealController::class, "editDeal"]);
    Route::get("deleteDeal", [DealController::class, "deleteDeal"]);
    Route::get("getAllDeals", [DealController::class, "getAllDeal"]);
});
