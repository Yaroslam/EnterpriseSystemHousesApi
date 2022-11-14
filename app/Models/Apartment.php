<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apartment extends EstateModel
{
    use HasFactory;

    protected $table = "apartments";
    protected $fillable = [
        'Address_City',
        'Address_Street',
        'Address_House',
        'Coordinate_latitude',
        'Coordinate_longitude',
        'Rooms',
        'Floor',
        'TotalArea',
    ];
    public $timestamps = false;



    public static function createApartment($data){
        self::insert([
            "Address_City" => $data["Address_City"],
            "Address_Street"  => $data["Address_Street"],
            "Address_House" => $data["Address_House"],
            "Address_Number" => $data["Address_Number"],
            "Coordinate_latitude" => $data["Coordinate_latitude"],
            "Coordinate_longitude" => $data["Coordinate_longitude"],
            "Rooms" => $data["Rooms"],
            "Floor" => $data["Floor"],
            "TotalArea" => $data["TotalArea"],
        ]);
    }

    public static function deleteApartment($id){
        if (count(DB::table("proposals_apartments")->where("apartment_id", $id)->get()->toArray()) >= 1) {
            return false;
        } else {
            self::where("id", $id)->delete();
            return true;
        }
    }

    public static function editApartment($id,$data){
        self::where('id', $id)->update([
                "Address_City" => $data["Address_City"],
                "Address_Street"  => $data["Address_Street"],
                "Address_House" => $data["Address_House"],
                "Address_Number" => $data["Address_Number"],
                "Coordinate_latitude" => $data["Coordinate_latitude"],
                "Coordinate_longitude" => $data["Coordinate_longitude"],
                "Rooms" => $data["Rooms"],
                "Floor" => $data["Floor"],
                "TotalArea" => $data["TotalArea"],
            ]);
    }

    public static function loadFromCSV($csv){
        foreach ($csv as $line){
            $data  = str_getcsv($line);
            if ($data[1] == "Address_City"){
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
                    "Rooms" => (int)$data[8],
                    "Floor" => (int)$data[9],
                    "TotalArea" => floatval($data[7]),
                ]);
            }
        }
    }




}
