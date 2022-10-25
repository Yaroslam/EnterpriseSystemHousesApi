<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proposal extends Model
{
    use HasFactory;
    protected $table = "proposals";
    protected $fillable = ["client","realtor","price"];
    public $timestamps = false;

    public static function getById($id){
        return self::where('id', $id)->get()->toArray();
    }

    public static function ApartmentsProposals(){
        return DB::table('proposals_apartments')->get()->toArray();
    }

    public static function HousesProposals(){
        return DB::table('proposals_houses')->get()->toArray();
    }

    public static function LandsProposals(){
        return DB::table('proposals_lands')->get()->toArray();
    }

    public static function deleteProposal($id, $proposal){
        DB::table("$proposal")->where('proposal_id', $id)->delete();
        self::where("id", $id)->delete();
    }

    public static function createProposal($clientId, $realtorId, $price, $type, $estateId){
        $id = self::insertGetId([
            "client" => $clientId,
            'realtor' => $realtorId,
            'price' => $price,
        ]);
        DB::table('proposals_'.$type)->insert([
            "proposal_id" => $id,
            mb_substr($type, 0, -1)."_id" => $estateId
        ]);
    }

    public static function updateProposal($id, $realtorId, $clientId, $price, $type, $estateId, $oldType){
        self::where("id", $id)->update([
            'realtor' => $realtorId,
            'client' => $clientId,
            'price' => $price
        ]);

        DB::table('proposals_'.$oldType)->where("proposal_id", $id)->delete();

        DB::table('proposals_'.$type)->insert([
            "proposal_id" => $id,
            mb_substr($type, 0, -1)."_id" => $estateId
        ]);
    }

}
