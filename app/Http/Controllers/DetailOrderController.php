<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail_order;
use Illuminate\Support\Facades\Validator;
use Exception;

class DetailOrderController extends Controller
{
    // endpoint for get all detail_orders
    public function showDetailOrders()
    {
        try {
            $detail_orders = Detail_order::all();
            if ($detail_orders->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No detail_orders found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Detail_orders found', 'detail_orders' => $detail_orders], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    //endpoint for create detail_order
    public function createDetailOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_dish' => 'required|integer',
                'id_order' => 'required|integer',
                'quantity' => 'required|integer',
                'subtotal' => 'required|numeric|min:0'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $detail_order = Detail_order::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Detail_order created', 'detail_order' => $detail_order], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update detail_order
    public function updateDetailOrder(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_order_detail' => 'required|integer',
                'id_dish' => 'required|integer',
                'id_order' => 'required|integer',
                'quantity' => 'required|integer',
                'subtotal' => 'required|numeric|min:0'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $detail_order = Detail_order::find($request->id_order_detail);
            $detail_order->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Detail_order updated', 'detail_order' => $detail_order], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete detail_order
    public function deleteDetailOrder(Request $request, $id)
    {
        try {
            $detail_order = Detail_order::find($request->id_order_detail);
            $detail_order->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Detail_order deleted', 'detail_order' => $detail_order], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }  
}
