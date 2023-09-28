<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\location;

class locationController extends Controller
{
    public function store(Request $request)
    {
        // Convert the JSON drawn region data to an array
        $drawnRegion = json_encode($request[0]['coordinates']);

        // If you need to further process the drawn region data, you can do so here
        // Insert the data into the 'locations' table using your Location model
        Location::create([
            'name' => $request[0]['type'],
            'points' => $drawnRegion,
            // Store the drawn region data
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
