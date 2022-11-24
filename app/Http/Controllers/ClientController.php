<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Carbon\Cli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function addClient(Request $request){
        if ($request['email'] == "" && $request['phoneNumber'] == ""){
            return Response(['error' => "enter phoneNumber or email"]);
        }

        $validator = Validator::make($request->all(), [
            "email" => 'email|unique:clients'
        ]);

        if ($validator->fails()) {
            return  Response($validator->errors(), 400);
        }
        $id = Client::all()->last()->id;
        Client::addClient($id, $request['name'], $request['surname'], $request['secondName'], $request['phoneNumber'], $request['email']);
        return Response([], 200);
    }

    public function deleteClient(Request $request){
        if(Client::deleteClient($request['id'])){
            return Response([], 200);
        } else {
            return Response(["errors" => "client in proposal or in requirement"], 400);
        }
    }

    public function editClient(Request $request){
        Client::updateClient($request['id'], $request['name'], $request['surname'], $request['secondName'], $request['phoneNumber'], $request['email']);
        return Response([], 200);
    }

    public function getAllClients(){
        return Client::getAllClients();
    }

    public function findClient(Request $request){
        return Client::findRealtor($request['name'], $request['surname'], $request['secondName']);

    }

    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        Client::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }

    public function getClientsProposal(Request $request){
        return Client::getClientProposals($request['id']);
    }

    public function getClientsRequirements(Request $request){
        return Client::getClientRequirements($request['id']);
    }

}
