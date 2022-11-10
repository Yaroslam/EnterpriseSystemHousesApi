<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;
    protected $table = "requirements";
    protected $fillable = ["realtor_id",
                        "client_id",
                        "estate_type",
                        "min_price",
                        "max_prince",
                        "min_square",
                        "max_square",
                        "min_rooms",
                        "max_rooms",
                        "max_floor",
                        "min_floor"
    ];
    public $timestamps = false;

    public static function createRequirement($type, $realtor_id, $client_id, $min_price, $max_price, $min_square, $max_square,
                                        $min_rooms, $max_rooms, $max_floor, $min_floor){
        self::insert([
            "realtor_id" => $realtor_id,
            "client_id" => $client_id,
            "estate_type" => $type,
            "min_price" => $min_price,
            "max_prince" => $max_price,
            "min_square" => $min_square,
            "max_square" => $max_square,
            "min_rooms" => $min_rooms,
            "max_rooms" => $max_rooms,
            "max_floor" => $min_floor,
            "min_floor" => $max_floor
        ]);
    }

    public static function getAll(){
        return self::all()->toArray();
    }

    public static function editRequirement($id,$type, $realtor_id, $client_id, $min_price, $max_price, $min_square, $max_square,
                                    $min_rooms, $max_rooms, $max_floor, $min_floor){
        self::where("id", $id)->update(
            [
                "realtor_id" => $realtor_id,
                "client_id" => $client_id,
                "estate_type" => $type,
                "min_price" => $min_price,
                "max_prince" => $max_price,
                "min_square" => $min_square,
                "max_square" => $max_square,
                "min_rooms" => $min_rooms,
                "max_rooms" => $max_rooms,
                "max_floor" => $min_floor,
                "min_floor" => $max_floor
            ]
        );
    }



}
