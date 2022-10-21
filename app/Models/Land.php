<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


    public static function getAllLands(){
        return self::all()->toArray();
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
                    "TotalArea" => floatval($data[7]),
                ]);
            }
        }
    }
}
