<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = [];

        if ($search) {
            $users = User::where('category', 'student')
                         ->where(function($query) use ($search) {
                             $query->where('name', 'like', "%$search%")
                                   ->orWhere('phone', 'like', "%$search%");
                         })->get();
        }

        return view('admin.charges.index', compact('users', 'search'));
    }

    public function charge(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:deposite,withdraw'
        ]);

        $userId = $request->input('user_id');
        $amount = $request->input('amount');
        $type = $request->input('type');
        try {
            $user = User::findOrFail($userId);

            if ($type === 'deposite') {
                $user->wallet += $amount;
            } elseif ($type === 'withdraw') {
                if ($user->wallet < $amount) {
                    return redirect()->back()->with('error', 'Insufficient balance for withdrawal.');
                }
                $user->wallet -= $amount;
            }

            $user->save();

            Transaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'method' => 'wallet',
                'status' => 'done',
                'type' => $type, // Can be 'deposit' or 'withdraw'
            ]);

            return redirect()->back()->with('success', ucfirst($type) . ' transaction completed successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
