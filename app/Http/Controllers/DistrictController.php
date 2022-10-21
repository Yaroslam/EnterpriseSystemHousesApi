<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function loadFromFile(Request $request){
        $request->file('file')->store('files');
        $csvFile = file($request->file('file'));
        District::loadFromCSV($csvFile);
        return ['ok' => 'done'];
    }
}
