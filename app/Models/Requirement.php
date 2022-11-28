<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                        "min_floor",
                        "address"
    ];
    public $timestamps = false;

    public static function createRequirement($type, $realtor_id, $client_id, $min_price, $max_price, $min_square, $max_square,
                                        $min_rooms, $max_rooms, $max_floor, $min_floor, $address){
        $id = self::insertGetId([
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
            "min_floor" => $max_floor,
            "address" => $address
        ]);
    }

    public static function editRequirement($id,$type, $realtor_id, $client_id, $min_price, $max_price, $min_square, $max_square,
                                    $min_rooms, $max_rooms, $max_floor, $min_floor, $address){
        self::where("id", $id)->update([
                "estate_type" => $type,
                "realtor_id" => $realtor_id,
                "client_id" => $client_id,
                "min_price" => $min_price,
                "max_prince" => $max_price,
                "min_square" => $min_square,
                "max_square" => $max_square,
                "min_rooms" => $min_rooms,
                "max_rooms" => $max_rooms,
                "max_floor" => $min_floor,
                "min_floor" => $max_floor,
                "address" => $address
            ]
        );
    }

    public static function deleteRequirement($id){
        $requirement  = self::where("id", $id);
        if(count(DB::table("deal_".$requirement->estate_type)->where("requirement_id", $id)->get()->toArray()) > 0){
            return false;
        } else {
            self::where("id", $id)->delete();
            return true;
        }
    }

    public static function getRequirement($id){
        return self::where("id", $id)->get()->toArray()[0];
    }

    public static function getAll(){
        return self::all()->toArray();
    }

    public static function findRequirementForProposal($proposalId, $typedProposalId, $type){
        $res = [];
        $proposal = Proposal::getById($proposalId);
        $requirements = self::getAll();
        $typedProposal = Proposal::getTypeProposalById($typedProposalId, $type);
        $typedProposal = json_decode(json_encode($typedProposal), true);
        foreach ($requirements as $requirement){
            if($type == "houses"){
                if($proposal['price'] >= $requirement['min_price'] && $proposal['price'] <= $requirement['max_price']){
                    $estate = House::getById($typedProposal['house_id'])[0];
                    if($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']){
                        if($estate['TotalFloors'] <= $requirement['max_floor'] && $estate['TotalFloors'] >= $requirement['min_floor']){
                           $res[] = $requirement;
                        }
                    }
                }
            } else if ($type == "apartments"){
                if($proposal['price'] >= $requirement['min_price'] && $proposal['price'] <= $requirement['max_price']){
                    $estate = Apartment::getById($typedProposal['apartment_id'])[0];
                    if($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']){
                        if($estate['Rooms'] <= $requirement['max_rooms'] && $estate['Rooms'] >= $requirement['min_rooms']) {
                            if ($estate['Floor'] <= $requirement['max_floor'] && $estate['Floor'] >= $requirement['min_floor']) {
                                $res[] = $requirement;
                            }
                        }
                    }
                }
            } else if ($type == 'lands'){
                if($proposal['price'] >= $requirement['min_price'] && $proposal['price'] <= $requirement['max_price']){
                    $estate = Land::getById($typedProposal['land_id'])[0];
                    if($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']){
                        $res[] = $requirement;
                    }
                }
            }

        }
        return $res;
    }

    public static function getById($id){
        return self::where("id", $id)->get()->toArray()[0];
    }



}
