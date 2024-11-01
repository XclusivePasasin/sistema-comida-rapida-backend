<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;
use Exception;

class TableController extends Controller
{
    // endpoint for get all tables
    public function showTables()
    {
        try {
            $tables = Table::paginate(10);
            if ($tables->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No tables found'],
                    404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Tables found', 'tables' => $tables],
                    200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    //endpoint for create table
    public function createTable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'table_number' => 'required|string|max:50|unique:tables,table_number'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }
            $table = Table::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Table created', 'table' => $table],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // endpoint for update table
    public function updateTable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_table' => 'required|integer',
                'table_number' => 'required|string|max:50',
                'status' => 'required|string|in:A,I', 
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            $table = Table::find($request->id_table);

            if (!$table) {
                return response()->json(
                    ['code' => 404, 'message' => 'Table not found'],
                    404
                );
            }

            $table->update([
                'table_number' => $request->table_number,
                'status' => $request->status,
            ]);

            return response()->json(
                ['code' => 200, 'message' => 'Table updated', 'table' => $table],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    public function updateTableStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_table' => 'required|integer',
                'status' => 'required|string|in:A,I',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            $table = Table::find($request->id_table);
    
            if (!$table) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Table not found'
                ], 404);
            }
    
            $table->status = $request->status;
            $table->save();
    
            return response()->json([
                'code' => 200,
                'message' => 'Table status updated',
                'table' => $table,
            ], 200);
    
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo de errores específicos de base de datos
            return response()->json([
                'code' => 500,
                'message' => 'Database query error',
                'error' => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // endpoint for delete table
    public function deleteTable(Request $request)
    {
        try {
            $table = Table::find($request->id_table);
            $table->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Table deleted', 'table' => $table],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // endpoint for checking if a table exists
    public function checkTableExistence(Request $request)
    {
        $tableNumber = $request->query('number');
        $idTable = $request->query('id_table'); 

        try {
            $query = Table::where('table_number', $tableNumber);

            if ($idTable) {
                $query->where('id_table', '!=', $idTable);
            }

            $exists = $query->exists();

            return response()->json([
                'exists' => $exists
            ], 200);
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // endpoint for searching tables
    public function searchTable(Request $request)
    {
        try {
            // Validación del término de búsqueda
            $validator = Validator::make($request->all(), [
                'table' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            
            $searchTerm = $request->input('table');

            
            $tables = Table::where('table_number', 'like', "%$searchTerm%")
                ->get();

            
            if ($tables->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No tables found'],
                    404
                );
            }

            
            return response()->json(
                ['code' => 200, 'message' => 'Tables found', 'tables' => $tables],
                200
            );
        } catch (Exception $e) {
            
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    public function showAvailableTables()
    {
        try {
            $tables = Table::where('status', 'A')->paginate(10);
            
            if ($tables->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No available tables found'],
                    404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Available tables found', 'tables' => $tables],
                    200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

}
