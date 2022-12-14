<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Realtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RealtorController extends Controller
{
    public function addRealtor(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "surname" => 'required',
            "secondName" => 'required',
        ]);

        if ($validator->fails()) {
            return  Response($validator->errors(), 400);
        }

        Realtor::addRealtor($request['name'], $request['surname'], $request['secondName'], $request['part']);
        return Response([], 200);
    }

    public function deleteRealtor(Request $request){
        if(Realtor::deleteRealtor($request['id'])){
            return Response([], 200);
        } else {
            return Response(["errors" => "realtor in proposal or in requirement"], 400);
        }
    }

    public function editRealtor(Request $request){
        Realtor::updateRealtor($request['id'], $request['name'], $request['surname'], $request['secondName'], $request['part']);
        return Response([], 200);
    }

    public function getAllRealtors(){
        return Realtor::getAllRealtors();
    }

    public function findRealtor(Request $request){
        return Realtor::findRealtor($request['name'], $request['surname'], $request['secondName']);
    }

    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        Realtor::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }

    public function getRealtorProposal(Request $request){
        return Realtor::getRealtorProposals($request['id']);
    }

    public function getRealtorRequirements(Request $request){
        return Realtor::getRealtorRequirements($request['id']);
    }

    public function getById(Request $request){
        return Realtor::getById($request['id']);
    }

}
