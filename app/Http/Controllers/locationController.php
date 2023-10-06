<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\location;

class locationController extends Controller
{
    public function store(Request $request)
    {

        $drawnRegion = json_encode($request[0]['coordinates']);

        Location::create([
            'name' => $request[0]['type'],
            'points' => $drawnRegion,

        ]);

        return redirect('success')->with('message', 'Location saved successfully');
    }


    public function viewLocations()
    {
        $locations = Location::all(); // Retrieve saved locations from the database

        // Convert locations to a JSON string
        $locationsJson = $locations->toJson();

        return view('view-location', compact('locationsJson'));
    }






}
