<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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



    public static function addRealtor($name, $surname, $secondName, $part){
        self::insert([
            'name' => $name,
            'surname' => $surname,
            'secondName' => $secondName,
            'part' => $part,
        ]);
    }

    public static function deleteRealtor($id){
        self::where("id", $id)->delete();
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

}
