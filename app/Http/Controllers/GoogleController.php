<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class GoogleController extends Controller
{
    public function googleMap()
    {
        return view('googleAutocomplete');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'required|json', // Ensure the points field is valid JSON
        ]);

        // Create a new location record
        $location = new Location([
            'name' => $request->input('name'),
            'points' => json_decode($request->input('points')), // Decode JSON string to array
        ]);

        // Save the location record to the database
        $location->save();

        // Return a response, such as a success message or a redirect
        return response()->json(['message' => 'Location saved successfully'], 200);
    }

    // You can add other methods for viewing and managing locations as needed
}
