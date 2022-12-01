<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function createEvent(Request $request){

        $validator = Validator::make($request->all(), [
            "type" => ['required', Rule::in(['meeting', 'presentation', 'phone_call'])],
            "date" => "required",
        ]);

        if ($validator->fails()) {
            return  Response($validator->errors(), 400);
        }
        return Event::createEvent($request['realtorId'], date("Y-m-d H:i:s", $request['date']),
                                    $request['type'], $request['duration'], $request['comment']);
    }

    public function getEventsBetween(Request $request){
        return Event::getEventsBetweenDates(date("Y-m-d H:i:s", $request['startDate']), date("Y-m-d H:i:s", $request['endDate']));
    }

    public function deleteEvent(Request $request){
        Event::canselEvent($request['eventId']);
    }




}
