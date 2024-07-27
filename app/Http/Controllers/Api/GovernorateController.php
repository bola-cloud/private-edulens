<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the governorates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $governorates = Governorate::all();

        return response()->json($governorates);
    }
}
