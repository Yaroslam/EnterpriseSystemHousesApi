<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\House;
use App\Models\Land;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function getAllEstate(){
        return ["Apartments" => Apartment::getAll(), "Houses" => House::getAll(),
            "Lands" => Land::getAll()];
    }

    public function SearchEstateByAddress(Request $request){
        $apartments = Apartment::SearchByAddress($request['city'], $request['street'], $request['house'], $request['number']);
        $houses = House::SearchByAddress($request['city'], $request['street'], $request['house'], $request['number']);
        $lands = Land::SearchByAddress($request['city'], $request['street'], $request['house'], $request['number']);
        return ["Houses" => $houses, "Apartments" => $apartments, "Land" => $lands];
//        return ["Apartments" => $apartments];
    }

    public function SearchEstateByDistrict(Request $request){
        $estates = [House::getAll(), Apartment::getAll(), Land::getAll()];
        $res = [];
        $isBelong = false;
        $coords =  substr(Apartment::SearchByDistrict($request['district']),1, -1);
        $coords = explode(',', $coords);
        $coords = (array_chunk($coords, 2));
        foreach ($coords as &$cord) {
            foreach ($cord as &$singleCord) {
                $singleCord = trim($singleCord, "(");
                $singleCord = trim($singleCord, ")");
                $singleCord = (float)$singleCord;
            }
        }

        $pointsCount = count($coords);
        $j = $pointsCount-1;
        foreach ($estates as $estate) {
            foreach ($estate as $point) {
                $isBelong = false;
                for ($i = 0; $i < $pointsCount; $i++) {
                    if (($coords[$i][1] < $point['Coordinate_longitude'] && $coords[$j][1] >= $point['Coordinate_longitude']
                            || $coords[$j][1] < $point['Coordinate_longitude'] && $coords[$i][1] >= $point['Coordinate_longitude'])
                        && ($coords[$i][0] + ($point['Coordinate_longitude'] - $coords[$i][1]) / ($coords[$j][1] - $coords[$i][1]) * ($coords[$j][0] - $coords[$i][0]) < $point["Coordinate_latitude"])) {
                        $isBelong = !$isBelong;
                    }
                    $j = $i;
                }
                if($isBelong) {
                    $res[] = $point;
                }
            }
        }
        return $res;
    }

    public function createEstate(){

    }

    public function deleteEstate(){

    }

    public function updateEstate(){

    }



}
