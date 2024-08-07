<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        // Assuming you fetch grades and governorates for the registration form
        $grades = \App\Models\Grade::all();
        $governorates = \App\Models\Governorate::all();

        return view('auth.register', compact('grades', 'governorates'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['phone' => 'Unauthorized'])->withInput();
    }

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

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    public function admin()
    {
        return view('admin.dashboard');
    }
}