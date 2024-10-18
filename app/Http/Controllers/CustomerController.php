<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // endpoint for get all customers
    public function showCustomers()
    {
        try {
            $customers = Customer::all();
            if ($customers->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No customers found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Customers found', 'customers' => $customers], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }
    
    // endpoint for create customer
    public function createCustomer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'dui' => 'required|string|max:10',
                'first_name' => 'required|string|max:70',
                'last_name' => 'required|string|max:70',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:8'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $customer = Customer::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Customer created', 'customer' => $customer], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    //endpoint for update customer
    public function updateCustomer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'dui' => 'required|string|max:10',
                'first_name' => 'required|string|max:70',
                'last_name' => 'required|string|max:70',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:8'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $customer = Customer::find($request->dui);
            $customer->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Customer updated', 'customer' => $customer], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete customer
    public function deleteCustomer(Request $request)
    {
        try {
            $customer = Customer::find($request->dui);
            $customer->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Customer deleted', 'customer' => $customer], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }
}
