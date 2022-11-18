<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Realtor extends Model
{
    use HasFactory;
    protected $table = 'realtors';
    protected $fillable = [
        'name',
        'surname',
        'secondName',
        'part'
    ];
    public $timestamps = false;



    public static function getById($id){
        return self::where("id", $id)->get()->toArray()[0];
    }

    public static function addRealtor($name, $surname, $secondName, $part){
        self::insert([
            'name' => $name,
            'surname' => $surname,
            'secondName' => $secondName,
            'part' => $part,
        ]);
    }

    public static function deleteRealtor($id){
        if(count(self::getRealtorProposals($id)) >= 1 || count(self::getRealtorRequirements($id)) >= 1){
            return false;
        } else {
            self::where("id", $id)->delete();
            return true;
        }
    }

    public static function updateRealtor($id ,$name, $surname, $secondName, $part){
        self::where("id", $id)->update(
            [
                'name' => $name,
                'surname' => $surname,
                'secondName' => $secondName,
                'part' => $part
            ]
        );
    }

    public static function getAllRealtors(){
        return self::all()->toArray();
    }

    public static function findRealtor($name, $surname, $secondName){
        $res = [];
        $realtors = self::all()->toArray();
        foreach ($realtors as $realtor){
            if (levenshtein($name, $realtor['name']) <= 3 && levenshtein($surname, $realtor['surname']) <= 3 && levenshtein($secondName, $realtor['secondName']) <= 3){
                $res[] = $realtor;
            }
        }
        return $res;
    }

    public static function loadFromCSV($csv){
        foreach ($csv as $line){
            $data  = str_getcsv($line);
            if ($data[1] == "FirstName"){
                continue;
            } else {
                self::insert([
                    "id" => (int)$data[0],
                    "name" => trim($data[1]),
                    "surname" => trim($data[2]),
                    "secondName" => trim($data[3]),
                    'part' => trim($data[4])
                ]);
            }
        }
    }

    public static function getRealtorRequirements($id){
        return DB::table('requirements')->where("realtor_id", $id)->get()->toArray();
    }

    public static function getRealtorProposals($id){
        return DB::table('proposals')->where("realtor", $id)->get()->toArray();
    }

}
