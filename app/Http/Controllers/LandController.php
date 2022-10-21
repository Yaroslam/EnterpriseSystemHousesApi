<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Land;
use Illuminate\Http\Request;

class LandController extends Controller
{

    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        Land::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }
}
