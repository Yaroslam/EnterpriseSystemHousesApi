<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proposal extends Model
{
    use HasFactory;

    protected $table = "proposals";
    protected $fillable = ["client", "realtor", "price"];
    public $timestamps = false;

    public static function getById($id)
    {
        return self::where('id', $id)->get()->toArray()[0];
    }

    public static function getTypeProposalById($proposalId, $type)
    {
        return DB::table("proposals_" . $type)->where('proposal_id', $proposalId)->get()->toArray()[0];
    }

    public static function ApartmentsProposals()
    {
        return DB::table('proposals_apartments')->get()->toArray();
    }

    public static function HousesProposals()
    {
        return DB::table('proposals_houses')->get()->toArray();
    }

    public static function LandsProposals()
    {
        return DB::table('proposals_lands')->get()->toArray();
    }

    public static function deleteProposal($id, $proposal)
    {
        $houses = DB::table("deal_houses")->where("proposal_id", $id)->get()->toArray();
        $lands = DB::table("deal_lands")->where("proposal_id", $id)->get()->toArray();
        $apartments = DB::table("deal_apartments")->where("proposal_id", $id)->get()->toArray();

        if (count($apartments) > 0 || count($lands) > 0 || count($houses) > 0) {
            return false;
        } else {
            DB::table("$proposal")->where('proposal_id', $id)->delete();
            self::where("id", $id)->delete();
            return true;

        }
    }

    public static function createProposal($clientId, $realtorId, $price, $type, $estateId)
    {
        $id = self::insertGetId([
            "client" => $clientId,
            'realtor' => $realtorId,
            'price' => $price,
        ]);
        DB::table('proposals_' . $type)->insert([
            "proposal_id" => $id,
            mb_substr($type, 0, -1) . "_id" => $estateId
        ]);
    }

    public static function updateProposal($id, $realtorId, $clientId, $price, $type, $estateId, $oldType)
    {
        self::where("id", $id)->update([
            'realtor' => $realtorId,
            'client' => $clientId,
            'price' => $price
        ]);

        DB::table('proposals_' . $oldType)->where("proposal_id", $id)->delete();

        DB::table('proposals_' . $type)->insert([
            "proposal_id" => $id,
            mb_substr($type, 0, -1) . "_id" => $estateId
        ]);
    }

    public static function findProposalForRequirement($requirementId)
    {
        $res = [];
        $requirement = Requirement::getById($requirementId);
        $estateType = $requirement['estate_type'];

        if ($estateType == "houses") {
            $proposals = self::HousesProposals();
        } else if ($estateType == "lands") {
            $proposals = self::LandsProposals();
        } else if ($estateType == 'apartments') {
            $proposals = self::ApartmentsProposals();
        }

        foreach ($proposals as $proposal) {
            if ($estateType == "houses") {
                $basicProposal = self::getById($proposal['proposal_id']);
                $estate = House::getById($proposal['house_id'])[0];

                if ($basicProposal['price'] >= $requirement['min_price'] && $basicProposal['price'] <= $requirement['max_price']) {
                    if ($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']) {
                        if ($estate['TotalFloors'] <= $requirement['max_floor'] && $estate['TotalFloors'] >= $requirement['min_floor']) {
                            $res[] = $requirement;
                        }
                    }
                }

            } else if ($estateType == "lands") {
                $basicProposal = self::getById($proposal['proposal_id']);
                $estate = Land::getById($proposal['land_id'])[0];

                if ($basicProposal['price'] >= $requirement['min_price'] && $basicProposal['price'] <= $requirement['max_price']) {
                    if ($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']) {
                        $res[] = $requirement;
                    }
                }
            } else if ($estateType == 'apartments') {
                $basicProposal = self::getById($proposal['proposal_id']);
                $estate = Apartment::getById($proposal['apartment_id'])[0];

                if ($basicProposal['price'] >= $requirement['min_price'] && $basicProposal['price'] <= $requirement['max_price']) {
                    if ($estate['TotalArea'] <= $requirement['max_square'] && $estate['TotalArea'] >= $requirement['min_square']) {
                        if ($estate['Rooms'] <= $requirement['max_rooms'] && $estate['Rooms'] >= $requirement['min_rooms']) {
                            if ($estate['Floor'] <= $requirement['max_floor'] && $estate['Floor'] >= $requirement['min_floor']) {
                                $res[] = $requirement;
                            }
                        }
                    }
                }
            }
        }
        return $res;
    }


}
