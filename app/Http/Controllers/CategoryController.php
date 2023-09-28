<?php

namespace App\Http\Controllers;

use App\Models\Catagorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catagories = catagorie::all();
        return view('catagory.index', compact('catagories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catagory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validateData = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'parent_id' => 'required',

        ]);
        $catagory = new catagorie();
        $catagory->name = $validateData['name'];
        $catagory->status = $validateData['status'];
        $catagory->parent_id = $validateData['parent_id'];
        $catagory->save();
        // $catagories = catagorie::all();
        //    dd($catagories);
        // return view('catagory.index', compact('catagories'));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $catagory = catagorie::find($id);
        // dd($catagory);
        return view('catagory.index', compact('catagorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'parent_id' => 'required',

        ]);
        $catagory = catagorie::find($id);
        $catagory->name = $validateData['name'];
        $catagory->status = $validateData['status'];
        $catagory->parent_id = $validateData['parent_id'];
        $catagory->save();
        return response()->json($catagory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
