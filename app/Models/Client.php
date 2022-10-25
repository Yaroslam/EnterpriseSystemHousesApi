<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email',
        'surname',
        'secondName',
        'telephoneNumber'
    ];
    public $timestamps = false;



    public static function addClient($name, $surname, $secondName, $phoneNumber, $email){
        self::insert([
            'name' => $name,
            'surname' => $surname,
            'secondName' => $secondName,
            'email' => $email,
            'telephoneNumber' => $phoneNumber
        ]);
    }

    public static function deleteClient($id){
        self::where("id", $id)->delete();
    }

    public static function updateClient($id ,$name, $surname, $secondName, $phoneNumber, $email){
        self::where("id", $id)->update(
            [
                'name' => $name,
                'surname' => $surname,
                'secondName' => $secondName,
                'email' => $email,
                'telephoneNumber' => $phoneNumber
            ]
        );
    }

    public static function getAllClients(){
        return self::all()->toArray();
    }

    public static function findClient($name, $surname, $secondName){
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
            if ($data[0] == "id"){
                continue;
            } else {
              self::insert([
                  "id" => (int)$data[0],
                  "name" => trim($data[1]),
                  "surname" => trim($data[2]),
                  "secondName" => trim($data[3]),
                  "telephoneNumber" => trim($data[5]),
                  "email" => trim($data[5])
              ]);
            }
        }
    }

}
