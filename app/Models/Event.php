<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;

    protected $table = "events";
    protected $fillable = ["agent_id", "datetime", "type", "duration", "comment"];
    public $timestamps = false;


    public static function createEvent($realtorId, $date, $type, $duration, $comment){
        $id = DB::table("events")->insertGetId([
            "agent_id" => $realtorId,
            "datetime" => $date,
            "type" => $type,
            "duration" => $duration,
            "comment" => $comment
        ]);

        return DB::table("events")->where("id", $id)->get()->toArray()[0];
    }

    public static function getEventsBetweenDates($startDate, $endDate, $realtorId){
        return DB::table("events")->where("agent_id", $realtorId)->whereBetween("datetime", [$startDate, $endDate])->get()->toArray();
    }

    public static function canselEvent($id){
        DB::table("events")->where("id", $id)->delete();
    }

}
