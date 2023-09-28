<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $role= Role::all();
        return view('backend.roles.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $permission= DB::table('permissions')->select('id','title')->get();
        $permission=DB::select('select * from  permissions ');

        return view('backend.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                // Validate the incoming request data
                $validatedData = $request->validate([
                    'name' => 'required',
                    'title' => 'required',
                    'guard_name' => 'required',
                    // Add more validation rules for other fields
                ]);
            // dd($request->all());
                // Create a new instance of the model
                $model = new Role(); // Replace "YourModel" with your actual model name

                // Set the attributes with the validated data
                $model->name = $validatedData['name'];
                $model->title = $validatedData['title'];
                $model->guard_name = $validatedData['guard_name'];
                // Set more attributes for other fields

                // Save the model to insert the data into the database
                $model->save();
                $model->syncPermissions($request->permissions);

                // Redirect the user or perform any other action
                $role= Role::all();
                return view('backend.roles.index', compact('role'));
            }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        // return view('')->with('permission',$permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);

    return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'title' => 'required',
            'guard_name' => 'required',
            // Add more validation rules for other fields
        ]);

        $role = Role::find($id);
        $role->name = $validatedData['name'];
        $role->title = $validatedData['title'];
        $role->guard_name = $validatedData['guard_name'];
        // Update more attributes as needed

        $role->save();

        return response()->json($role); // Return the updated role as a JSON response
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $role->delete();

        return $this->index();
    }
}
