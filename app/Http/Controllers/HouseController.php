<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Realtor;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        House::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }
}
