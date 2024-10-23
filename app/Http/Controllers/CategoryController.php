<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    // Endpoint para obtener todas las categorías
    public function showCategories()
    {
        try {
            $categories = Category::paginate(10); // 10 usuarios para paginación
            if ($categories->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No categories found'],
                    404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Categories found', 'categories' => $categories],
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

    // Endpoint para crear categoría
    public function createCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }
            $category = Category::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Category created', 'category' => $category],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // Endpoint para actualizar categoría
    public function updateCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_category' => 'required|integer',
                'name' => 'required|string|max:50'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }
            $category = Category::find($request->id_category);
            if (!$category) {
                return response()->json(
                    ['code' => 404, 'message' => 'Category not found'],
                    404
                );
            }
            $category->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Category updated', 'category' => $category],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // Endpoint para eliminar categoría
    public function deleteCategory(Request $request)
    {
        try {
            $category = Category::find($request->id_category);
            if (!$category) {
                return response()->json(
                    ['code' => 404, 'message' => 'Category not found'],
                    404
                );
            }
            $category->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Category deleted', 'category' => $category],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

    // Endpoint for search
    public function searchCategories(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'search' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            $searchTerm = $request->input('search');

            $categories = Category::where('name', 'like', "%$searchTerm%")
                ->get();

            if ($categories->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No categories found'],
                    404
                );
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Categories found', 'categories' => $categories],
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
    // Endpoint to verify if exists
    public function checkCategoryExists(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()],
                    400
                );
            }

            $name = $request->input('name');

            $exists = Category::where('name', $name)->exists();

            return response()->json(['exists' => $exists], 200);
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'],
                500
            );
        }
    }

}
