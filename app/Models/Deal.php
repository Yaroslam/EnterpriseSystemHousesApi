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

            DB::table("proposals")->where("id", $proposalId)->update(['use' => 1]);
            DB::table("requirements")->where("id", $requirementsId)->update(['use' => 1]);

            DB::table("deal_".$type)->insert([
                "proposal_id" => $proposalId,
                "requirement_id" => $requirementsId
            ]);
            return true;
        }
    }

    public static function deleteDeal($dealId, $type){
        $deal = DB::table("deal_".$type)->where("id", $dealId)->get()->toArray()[0];
        $deal = json_decode(json_encode($deal), true);
        $proposalId = $deal['proposal_id'];
        $requirementId = $deal['requirement_id'];
        DB::table("proposals")->where("id", $proposalId)->update(['use' => 0]);
        DB::table("requirements")->where("id", $requirementId)->update(['use' => 0]);
        DB::table("deal_".$type)->where("id", $dealId)->delete();
    }

    public static function editDeal($dealId, $proposalId, $requirementsId, $type){
        $requirement = Requirement::getRequirement($requirementsId);
        $proposal = Proposal::getById($proposalId);

        if($proposal['use'] || $requirement['use']){
            return false;
        } else {
            $deal = DB::table("deal_".$type)->where("id", $dealId)->get()->toArray();
            $deal = json_decode(json_encode($deal), true);
            DB::table("proposals")->where("id", $deal[0]['proposal_id'])->update(['use' => 0]);
            DB::table("proposals")->where("id", $proposalId)->update(['use' => 1]);
            DB::table("requirements")->where("id", $deal[0]['requirement_id'])->update(['use' => 0]);
            DB::table("requirements")->where("id", $requirementsId)->update(['use' => 1]);
            DB::table("deal_".$type)->where("id", $dealId)->update([
                "proposal_id" => $proposalId,
                "requirement_id" => $requirementsId
            ]);
            return true;
        }
    }

    public static function getAllDeal($type){
        return DB::table("deal_".$type)->get()->toArray();
    }




}
