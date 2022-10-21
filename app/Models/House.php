<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends EstateModel
{
    use HasFactory;

    public static function getAllHouses(){
        return self::all()->toArray();
    }

    public static function createHouse($data){

    }

    public static function deleteHouse($id){
        self::where("id", $id)->delete();
    }

    public static function updateHouse($id, $data){

    }

    public static function loadFromCSV($csv){
        foreach ($csv as $line){
            $data  = str_getcsv($line);
            if ($data[1] == "FirstName"){
                continue;
            } else {
                self::insert([
                    "id" => (int)$data[0],
                    "Address_City" => trim($data[1]),
                    "Address_Street"  => trim($data[2]),
                    "Address_House" => trim($data[3]),
                    "Address_Number" => trim($data[4]),
                    "Coordinate_latitude" => floatval($data[5]),
                    "Coordinate_longitude" => floatval($data[6]),
                    "TotalFloors" => (int)$data[8],
                    "TotalArea" => floatval($data[7]),
                ]);
            }
        }
    }


}
