<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Transaction::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('amount', 'like', "%$search%")
                    ->orWhere('method', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                          ->orWhere('last_name', 'like', "%$search%")
                          ->orWhere('phone', 'like', "%$search%");
                    });
            });
        }

        $transactions = $query->paginate(20);

        return view('admin.transactions.index', compact('transactions', 'search'));
    }

    public static function translateMethod($method)
    {
        $translations = [
            'paymob' => 'بايموب',
            'wallet' => 'محفظة',
            'code' => 'كود'
        ];

        return $translations[$method] ?? $method;
    }

    public static function translateStatus($status)
    {
        $translations = [
            'done' => 'تمت',
            'pendding' => 'معلقة',
            'refused' => 'مرفوضة'
        ];

        return $translations[$status] ?? $status;
    }

    public static function translateType($type)
    {
        $translations = [
            'deposite' => 'إيداع',
            'withdraw' => 'سحب'
        ];

        return $translations[$type] ?? $type;
    }
}
