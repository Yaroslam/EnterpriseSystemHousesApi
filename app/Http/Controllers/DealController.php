<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Proposal;
use App\Models\Realtor;
use App\Models\Requirement;
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
        } else {
            $proposal = Proposal::getById($request['proposalId']);
            $requirement = Requirement::getById($request['$requirementsId']);
            $realtorBuyer = Realtor::getById($requirement['realtor_id']);
            $realtorSeller = Realtor::getById($proposal['realtor']);
            $realtorSellerPrice = 0;
            $realtorBuyerPrice = 0;
            $companyBuyerPrice = 0;
            $companySellerPrice = 0;

            if($request['type'] == 'houses'){
                $companySellerPrice = 30000 + 0.01*$proposal['price'];
                $companyBuyerPrice = 0.03*$proposal['price'];
            } else if ($request['type'] == "lands"){
                $companySellerPrice = 30000 + 0.02*$proposal['price'];
                $companyBuyerPrice = 0.03*$proposal['price'];
            } else if ($request['type'] == 'apartments'){
                $companySellerPrice = 36000 + 0.01*$proposal['price'];
                $companyBuyerPrice = 0.03*$proposal['price'];
            }

            if($realtorBuyer["part"] == null){
                $realtorBuyerPrice = $companyBuyerPrice*0.45;
            } else {
                $realtorBuyerPrice = $companyBuyerPrice*$realtorBuyer['part']*0.01;
            }

            if($realtorSeller["part"] == null){
                $realtorSellerPrice = $companySellerPrice*0.45;
            } else {
                $realtorSellerPrice = $companySellerPrice*$realtorBuyer['part']*0.01;
            }

            $responseData = ["PriceOfBuyCompany" => $companyBuyerPrice, "PriceOfSellCompany" => $companySellerPrice,
                            "partOfBuyRealtor" => $realtorBuyerPrice, "partOfSellerRealtor" => $realtorSellerPrice,
                            "partOfBuyerCompany" => $companyBuyerPrice - $realtorBuyerPrice, "partOfSellerCompany" => $companySellerPrice - $realtorSellerPrice];

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
