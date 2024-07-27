<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the grades.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $grades = Grade::all();

        return response()->json($grades);
    }
}
