<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deal extends Model
{
    use HasFactory;

    public static function createDeal($proposalId, $requirementsId, $type){
        $requirement = Requirement::getRequirement($requirementsId);
        $proposal = Proposal::getById($proposalId);

        if($proposal['use'] || $requirement['use']){
            return false;
        } else {

            DB::table("proposal")->where("id", $proposalId)->update(['use' => true]);
            DB::table("requirements")->where("id", $requirementsId)->update(['use' => true]);

            DB::table("deal_".$type)->insert([
                "proposal_id" => $proposalId,
                "requirement_id" => $requirementsId
            ]);
            return true;
        }
    }

    public static function deleteDeal($dealId, $type){
        DB::table("deal_".$type)->where("id", $dealId)->delete();
    }

    public static function editDeal($dealId, $proposalId, $requirementsId, $type){
        $requirement = Requirement::getRequirement($requirementsId);
        $proposal = Proposal::getById($proposalId);

        if($proposal['use'] || $requirement['use']){
            return false;
        } else {
            DB::table("deal_".$type)->where("id", $dealId)->update([
                "proposal_id" => $proposalId,
                "requirement_id" => $requirementsId
            ]);
            return true;
        }
    }

    public static function getAllDeal($type){
        return DB::table("deal_".$type)->all()->toArray();
    }




}
