<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return redirect()->route('dashboard');
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|unique:users',
            'parent_phone' => 'required|string',
            'gender' => 'required|in:ذكر,انثي',
            'grade_id' => 'nullable|exists:grades,id',
            'governorate_id' => 'nullable|exists:governorates,id',
            'type' => 'required|in:center,online',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'parent_phone' => $request->parent_phone,
            'gender' => $request->gender,
            'grade_id' => $request->grade_id,
            'governorate_id' => $request->governorate_id,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);

        // Assuming you want to log in the user after registration
        Auth::login($user);

        // Return an Inertia response with the authenticated user data
        return redirect()->route('login');
    }

    public function admin()
    {
        return view('admin.dashboard');
    }
}
