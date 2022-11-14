<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Land extends EstateModel
{
    use HasFactory;
    protected $table = "lands";
    protected $fillable = [
        'Address_City',
        'Address_Street',
        'Address_House',
        'Coordinate_latitude',
        'Coordinate_longitude',
        'TotalArea',
    ];
    public $timestamps = false;

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
                    "TotalArea" => floatval($data[7]),
                ]);
            }
        }
    }

    public static function createLand($data){
        self::insert([
            "Address_City" => $data["Address_City"],
            "Address_Street"  => $data["Address_Street"],
            "Address_House" => $data["Address_House"],
            "Address_Number" => $data["Address_Number"],
            "Coordinate_latitude" => $data["Coordinate_latitude"],
            "Coordinate_longitude" => $data["Coordinate_longitude"],
            "TotalArea" => $data["TotalArea"],
        ]);
    }

    public static function deleteLand($id){
        if (count(DB::table("proposals_lands")->where("land_id", $id)->get()->toArray()) >= 1) {
            return false;
        } else {
            self::where("id", $id)->delete();
            return true;
        }
    }
}
