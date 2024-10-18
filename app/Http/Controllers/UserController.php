<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // endpoint for get all users
    public function showUsers()
    {
        try {
            $users = User::all();
            if ($users->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No users found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Users found', 'users' => $users], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for create user
    public function createUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:15|unique:users',
                'password' => 'required|string|min:6|max:255',
                'role' => 'required|string|max:1',
                'employee_name' => 'required|string|max:70',
                'phone' => 'required|string|max:8'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $user = User::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'User created', 'user' => $user], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update user
    public function updateUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_user' => 'required|integer',
                'username' => 'required|string|max:15|unique:users',
                'password' => 'required|string|min:6|max:255',
                'role' => 'required|string|max:1',
                'employee_name' => 'required|string|max:70',
                'phone' => 'required|string|max:8'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $user = User::find($request->id_user);
            $user->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'User updated', 'user' => $user], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete user
    public function deleteUser(Request $request)
    {
        try {
            $user = User::find($request->id_user);
            $user->delete();
            return response()->json(
                ['code' => 200, 'message' => 'User deleted', 'user' => $user], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for search user
    public function searchUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|string'  
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }

            $searchTerm = $request->input('user');

            $users = User::where('username', 'like', "%$searchTerm%")
                ->orWhere('employee_name', 'like', "%$searchTerm%")
                ->orWhere('phone', 'like', "%$searchTerm%")
                ->get();

            if ($users->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No users found'], 404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Users found', 'users' => $users], 200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }

    }
}
