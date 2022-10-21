<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "districts";
    protected $fillable = ["name", "area"];

    public static function loadFromCSV($csv){
        foreach ($csv as $line){
            $data  = str_getcsv($line);
            if ($data[1] == "area"){
                continue;
            } else {
                self::insert([
                    "name" => $data[0],
                    'area' => $data[1]
                ]);
            }
        }
    }

    public static function getDistrictByName($name){
        return self::where("name", $name)->get()->toArray();
    }


}
