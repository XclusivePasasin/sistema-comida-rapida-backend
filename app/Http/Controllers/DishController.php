<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use Illuminate\Support\Facades\Validator;
use Exception;

class DishController extends Controller
{
    //endpoint for get all dishes
    public function showDishes()
    {
        try {
            $dishes = Dish::with('category')->paginate(10); // 10 dishes for page
            
            if ($dishes->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No dishes found'],
                    404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Dishes found', 'dishes' => $dishes],
                    200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error', 'error' => $e->getMessage()],
                500
            );
        }
    }
    // endpoint for create dish
    public function createDish(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'dish_name' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'id_category' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }
            $dish = Dish::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Dish created', 'dish' => $dish],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // endpoint for update dish
    public function updateDish(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_dish' => 'required|integer', 
                'dish_name' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'id_category' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            $dish = Dish::find($request->id_dish);

            if (!$dish) {
                return response()->json(
                    ['code' => 404, 'message' => 'Dish not found'],
                    404
                );
            }

            $dish->update($request->all());

            return response()->json(
                ['code' => 200, 'message' => 'Dish updated', 'dish' => $dish],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error', 'error' => $e->getMessage()],
                500
            );
        }
    }

    //endpoint for delete dish
    public function deleteDish(Request $request)
    {
        try {
            $dish = Dish::find($request->id_dish);
            $dish->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Dish deleted', 'dish' => $dish],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // Endpoint for searching dishes
    public function searchDish(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'dish' => 'required|string',
                'id_dish' => 'sometimes|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            $searchTerm = $request->input('dish');
            $id = $request->input('id_dish'); 

            $dishesQuery = Dish::with('category') 
            ->where('dish_name', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->orWhereHas('category', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            });

            if ($id) {
                $dishExists = Dish::whereRaw('LOWER(dish_name) = ?', [strtolower($searchTerm)])
                ->where('id_dish', '!=', $id)  // Ignorar si es el mismo platillo al editar
                ->first();
            
                if ($dishExists) {
                    return response()->json(
                        ['code' => 409, 'message' => 'Dish name already taken by another dish.'], 409
                    );
                }
            
                $currentDish = Dish::find($id);
                if ($currentDish && $currentDish->dish_name === $searchTerm) {
                    return response()->json(
                        ['code' => 200, 'message' => 'Dish can be updated', 'dish' => $currentDish], 200
                    );
                }
            }
                

            $dishes = $dishesQuery->get();

            if ($dishes->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No dishes found'], 404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Dishes found', 'dishes' => $dishes],
                    200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error', 'error' => $e->getMessage()],
                500
            );
        }
    }
}

