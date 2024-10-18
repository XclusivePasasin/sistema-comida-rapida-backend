<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // endpoint for get all categories
    public function showCategories()
    {
        try {
            $categories = Category::all();
            if ($categories->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No categories found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Categories found', 'categories' => $categories], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for create category
    public function createCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $category = Category::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Category created', 'category' => $category], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update category
    public function updateCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_category' => 'required|integer',
                'name' => 'required|string|max:50'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $category = Category::find($request->id_category);
            $category->update($request->all());
            return response()->json(
                ['code' => 200, 'message' => 'Category updated', 'category' => $category], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for delete category
    public function deleteCategory(Request $request)
    {
        try {
            $category = Category::find($request->id_category);
            $category->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Category deleted', 'category' => $category], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }
}
