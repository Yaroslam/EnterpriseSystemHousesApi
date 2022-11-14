<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deal extends Model
{
    use HasFactory;

    public function createDeal($proposalId, $requirementsId, $type){
        DB::table("deal_".$type)->insert([
            "proposal_id" => $proposalId,
            "requirement_id" => $requirementsId
        ]);
    }

    public function deleteDeal($dealId, $type){
        DB::table("deal_".$type)->where("id", $dealId)->delete();
    }

    public function editDeal($dealId, $proposalId, $requirementsId, $type){
        DB::table("deal_".$type)->where("id", $dealId)->update([
            "proposal_id" => $proposalId,
            "requirement_id" => $requirementsId
        ]);
    }

    public function getAllDeal($type){
        return DB::table("deal_".$type)->all()->toArray();
    }




}
