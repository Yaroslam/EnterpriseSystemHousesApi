<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateModel extends Model
{

    public static function getAll(){
        return self::all()->toArray();
    }

    public static function SearchByAddress($city, $street, $house, $number){
        $res = [];
        $all = self::all()->toArray();
        foreach ($all as $a){
            if ((levenshtein($city, $a['Address_City']) <= 3 && levenshtein($street, $a['Address_Street']) <= 3) &&
                (levenshtein($house, $a['Address_House']) <= 1 && levenshtein($number, $a['Address_Number']) <= 1)){
                $res[] = $a;
            }
        }
        return $res;
    }

    public static function SearchByDistrict($districtName){
        $result = false;
        $district = District::getDistrictByName($districtName)[0];
        return $district['area'];
    }


    public static function getById($id){
        return self::where('id', $id)->get()->toArray();
    }

}
