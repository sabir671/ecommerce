<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\crude_event;
use Illuminate\Support\Carbon;

class CalenderController extends Controller
{
    public function index(Request $request)
{
    // dd($request->all());
    if ($request->ajax()) {
        $data = crude_event::all(['id', 'title', 'start_date', 'end_date', 'color'])->toArray();

// Transform the data to match FullCalendar's event format
$events = array_map(function ($event) {
    return [
        'id' => $event['id'],
        'title' => $event['title'],
        'start' => Carbon::parse($event['start_date'])->toIso8601String(),
        'end' => Carbon::parse($event['end_date'])->toIso8601String(),
        'color' => $event['color'],
    ];
}, $data);


        return response()->json($events);
    }


    // Fetch events for the calendar view (if needed)
    $events = crude_event::distinct('id')->select(['id', 'title', 'start_date', 'end_date', 'color'])->get()->toArray();



    return view('calender', compact('events'));
}


public function calendarEvents(Request $request)
{

    // Data validation
    $data = $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'color' => 'required',
    ]);

    $crudEvent = new crude_event();
    $crudEvent->title = $request->input('title');
    $crudEvent->description = $request->input('description');
    $crudEvent->start_date = $request->input('start_date');
    $crudEvent->end_date = $request->input('end_date');
    $crudEvent->color = $request->input('color');

    // Save the event to the database
    $crudEvent->save();


    // Return the event details including start_date and end_date
    return response()->json([
        'id' => $crudEvent->id,
        'title' => $crudEvent->title,
        'start' => $crudEvent->start_date,
        'end' => $crudEvent->end_date,
        'color' => $crudEvent->color,
    ]);










        // switch ($request->type) {
        //     case 'create':
        //         $event = CrudEvents::create([
        //             'event_name' => $request->event_name,
        //             'event_start' => $request->event_start,
        //             'event_end' => $request->event_end,
        //         ]);

        //         return response()->json($event);
        //         break;

        //     case 'edit':
        //         $event = CrudEvents::find($request->id)->update([
        //             'event_name' => $request->event_name,
        //             'event_start' => $request->event_start,
        //             'event_end' => $request->event_end,
        //         ]);

        //         return response()->json($event);
        //         break;

        //     case 'delete':
        //         $event = CrudEvents::find($request->id)->delete();

        //         return response()->json($event);
        //         break;

        //     default:
        //         # ...
        //         break;
        // }
    }
}
