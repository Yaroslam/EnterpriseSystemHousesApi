<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementsController extends Controller
{
    public function createRequirements(Request $request){
        Requirement::createRequirement($request['type'], $request['realtor_id'], $request['client_id'],
            $request['min_price'], $request['max_price'], $request['min_square'],
            $request['max_square'], $request['min_rooms'], $request['max_rooms'],
            $request['max_floor'], $request['min_floor'], $request['addres_street'], $request['addres_city'],
            $request['addres_house'], $request['addres_number']);
    }
    public function deleteRequirements(Request $request){
        $responseCode = 200;
        $responseData = [];
        if(!Requirement::deleteRequirement($request['id'])){
            $responseCode = 400;
            $responseData = ["error" => "requirements in deal"];
        }
        return Response($responseData, $responseCode);
    }

    public function editRequirements(Request $request){
        Requirement::editRequirement($request['id'],$request['type'], $request['realtor_id'], $request['client_id'],
            $request['min_price'], $request['max_price'], $request['min_square'],
            $request['max_square'], $request['min_rooms'], $request['max_rooms'],
            $request['max_floor'], $request['min_floor'], $request['addres_street'], $request['addres_city'],
            $request['addres_house'], $request['addres_number']);
    }

    public function findRequirementForProposal(Request $request){
        return Requirement::findRequirementForProposal($request['proposalId'], $request['typedProposalId'], $request['type']);
    }


}
