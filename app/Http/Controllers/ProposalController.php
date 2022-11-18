<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\House;
use App\Models\Land;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{

    public function getApartmentsProposal(){
        $res = [];
        $proposals = Proposal::ApartmentsProposals();
        foreach ($proposals as $proposal){
            $prop = [];
            $apartment = Apartment::getById($proposal->apartment_id)[0];
            $apartment['type'] = "apartment";
            $apartmentProposal = Proposal::getById($proposal->proposal_id);
            $prop['estate'] = $apartment;
            $prop['proposal'] =  $apartmentProposal[0];
            $res[] = $prop;
        }
        return $res;
    }

    public function getHousesProposal(){
        $res = [];
        $proposals = Proposal::HousesProposals();
        foreach ($proposals as $proposal){
            $prop = [];
            $apartment = House::getById($proposal->house_id)[0];
            $apartment['type'] = "house";
            $apartmentProposal = Proposal::getById($proposal->proposal_id);
            $prop['estate'] = $apartment;
            $prop['proposal'] =  $apartmentProposal[0];
            $res[] = $prop;
        }
        return $res;
    }


    public function getLandsProposal(){
        $res = [];
        $proposals = Proposal::LandsProposals();
        foreach ($proposals as $proposal){
            $prop = [];
            $apartment = Land::getById($proposal->land_id)[0];
            $apartment['type'] = "land";
            $apartmentProposal = Proposal::getById($proposal->proposal_id);
            $prop['estate'] = $apartment;
            $prop['proposal'] =  $apartmentProposal[0];
            $res[] = $prop;
        }
        return $res;
    }

    public function findProposalForRequirements(){

    }


    public function deleteProposal(Request $request){
        $responseCode = 200;
        $responseData = [];
        if(!Proposal::deleteProposal($request['proposal_id'], "proposals_".$request['type'])){
            $responseData = ['error' => "proposal in deal"];
            $responseCode = 400;
        }
        return Response($responseData, $responseCode);
    }

    public function createProposal(Request $request){
        Proposal::createProposal($request["clientId"], $request["realtorId"],
            $request["price"], $request["type"], $request["estateId"]);
    }

    public function updateProposal(Request $request){
        Proposal::updateProposal($request['id'], $request["realtorId"] ,$request["clientId"],
            $request["price"], $request['type'], $request["estateId"], $request['oldType']);
    }








}
