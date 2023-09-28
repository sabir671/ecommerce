<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function googleMap()
    {
        return view('googleAutocomplete');
    }
}
