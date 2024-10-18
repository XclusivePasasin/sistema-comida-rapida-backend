<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // endpoint for get all orders
    public function showOrders()
    {
        try {
            $orders = Order::all();
            if ($orders->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No orders found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Orders found', 'orders' => $orders], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    //endpoint for create order
    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_user' => 'required|integer',
                'order_date' => 'required|date',
                'customer_dui' => 'required|string|max:10',
                'id_table' => 'required|integer',
                'status' => 'required|string|max:1',
                'total' => 'required|numeric|min:0',
                'payment_method' => 'required|string|max:40'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $order = Order::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Order created', 'order' => $order], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update order status or payment_method
   public function updateOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_order' => 'required|integer',
                'status' => 'required|string|max:1',
                'payment_method' => 'required|string|max:40'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $order = Order::find($request->id_order);
            $order->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Order updated', 'order' => $order], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete order
    public function deleteOrder(Request $request)
    {
        try {
            $order = Order::find($request->id_order);
            $order->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Order deleted', 'order' => $order], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }
}
