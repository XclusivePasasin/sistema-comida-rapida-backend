<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    // endpoint for get all tables
    public function showTables()
    {
        try {
            $tables = Table::all();
            if ($tables->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No tables found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Tables found', 'tables' => $tables], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    //endpoint for create table
    public function createTable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'table_number' => 'required|string|max:4'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $table = Table::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Table created', 'table' => $table], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update table
    public function updateTable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_table' => 'required|integer',
                'table_number' => 'required|string|max:4'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $table = Table::find($request->id_table);
            $table->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Table updated', 'table' => $table], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete table
    public function deleteTable(Request $request)
    {
        try {
            $table = Table::find($request->id_table);
            $table->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Table deleted', 'table' => $table], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }  
}
