<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;


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

    // endpoint for login user
    public function loginUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:15|exists:users,username', 
                'password' => 'required|string|min:6|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Empty or invalid fields', 'errors' => $validator->errors()],
                    400
                );
            }
    
            $user = User::where('username', $request->username)->first();
    
            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json(
                    ['code' => 200, 'message' => 'Login successful', 'user' => $user->only(['id_user', 'username', 'employee_name', 'phone', 'role'])],
                    200
                );
            } else {
                return response()->json(
                    ['code' => 401, 'message' => 'Invalid username or password'],
                    401
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }


    // endpoint for create user
    public function createUser(Request $request)
    {
        try {
            // Validar las entradas
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:15|unique:users',
                'password' => 'required|string|min:6|max:255',
                'role' => 'required|string|max:1',
                'employee_name' => 'required|string|max:70',
                'phone' => 'required|string|max:8'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            // endpoint for create user
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password), // Hashear the password
                'role' => $request->role,
                'employee_name' => $request->employee_name,
                'phone' => $request->phone
            ]);

            return response()->json(
                ['code' => 201, 'message' => 'User created', 'user' => $user],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // endpoint for update user
    public function updateUser(Request $request, $id)
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
    public function deleteUser(Request $request,$id)
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
