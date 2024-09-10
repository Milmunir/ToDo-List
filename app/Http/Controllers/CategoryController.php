<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $result = category::all()->select("id", "name");
            return response()->json($result, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error'], 500);
        }
    }
}
