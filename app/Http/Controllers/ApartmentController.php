<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Client;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        Apartment::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }


    public function createApartment(Request $request){

    }

    public function deleteApartment(Request $request){

    }

    public function editApartment(Request $request){

    }
    







}
