<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->count() > 0) {
            return response()->json([
                'status' => 200,
                'users' => $users
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'no users found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:90',
            'email' => 'required|string|max:191',
            'password' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages() // Use messages() instead of message()
            ], 422);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'user created successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'something went wrong'
                ], 200);
            }
        }
    }

    public function show($id)
    {
        $users = User::find($id);

        if ($users) {
            return response()->json([
                'status' => 200,
                'users' => $users
            ], 200);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no user found'
            ], 404);
        }
    }

    public function edit($id){

        $users = User::find($id);
        if ($users) {
            return response()->json([
                'status' => 200,
                'users' => $users
            ], 200);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no user found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'No user found'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:90',
        'email' => 'required|string|max:191',
        'password' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->save();

    return response()->json([
        'status' => 200,
        'message' => 'User updated successfully',
        'user' => $user
    ], 200);
}

}
