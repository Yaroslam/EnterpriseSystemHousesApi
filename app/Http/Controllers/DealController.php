<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\DelegatesToResource;

class DealController extends Controller
{
    public function createDeal(Request $request){
        $responseCode = 200;
        $responseData = [];

        if(!Deal::createDeal($request['proposalId'], $request['$requirementsId'], $request['type'])){
            $responseCode = 400;
            $responseData = ['error' => "proposal or requirement in deal already"];
        }
        return Response($responseData, $responseCode);
    }

    public function editDeal(Request $request){
        $responseCode = 200;
        $responseData = [];

        if(!Deal::editDeal($request['dealId'], $request['proposalId'], $request['$requirementsId'], $request['type'])){
            $responseCode = 400;
            $responseData = ['error' => "proposal or requirement in deal already"];
        }
        return Response($responseData, $responseCode);
    }

    public function deleteDeal(Request $request){
        Deal::deleteDeal($request['dealId'], $request['type']);
    }

    public function getAllDeal(){
        $res = [];
        $types = ['houses', 'apartments', 'lands'];
        foreach ($types as $type){
            $res[] = Deal::getAllDeal($type);
        }
        return $res;
    }




}
