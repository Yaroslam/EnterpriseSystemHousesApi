<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class House extends EstateModel
{
    use HasFactory;


    public static function createHouse($data){
        $id = self::all()->last()->id;
        self::insert([
            "id" => $id+1,
            "Address_City" => $data["Address_City"],
            "Address_Street"  => $data["Address_Street"],
            "Address_House" => $data["Address_House"],
            "Address_Number" => $data["Address_Number"],
            "Coordinate_latitude" => $data["Coordinate_latitude"],
            "Coordinate_longitude" => $data["Coordinate_longitude"],
            "TotalFloors" => $data["TotalFloor"],
            "TotalArea" => $data["TotalArea"],
        ]);
    }

    public static function deleteHouse($id){
        if (count(DB::table("proposals_houses")->where("house_id", $id)->get()->toArray()) >= 1) {
            return false;
        } else {
            self::where("id", $id)->delete();
            return true;
        }
    }

    public static function editHouse($id, $data){
        self::where('id', $id)->update([
            "Address_City" => $data["Address_City"],
            "Address_Street"  => $data["Address_Street"],
            "Address_House" => $data["Address_House"],
            "Address_Number" => $data["Address_Number"],
            "Coordinate_latitude" => $data["Coordinate_latitude"],
            "Coordinate_longitude" => $data["Coordinate_longitude"],
            "TotalFloors" => $data["TotalFloors"],
            "TotalArea" => $data["TotalArea"],
        ]);
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
