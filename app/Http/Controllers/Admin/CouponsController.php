<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Coupon::query();

        if ($search) {
            $query->where('code', 'like', "%$search%");
        }

        $coupons = $query->paginate(100);
        $totalCoupons = Coupon::count();
        $filteredCouponsCount = $query->count();

        return view('admin.coupons.index', compact('coupons', 'search', 'totalCoupons', 'filteredCouponsCount'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_of_coupons' => 'required|integer|min:1',
            'value' => 'required|integer|min:1',
        ]);

        $numberOfCoupons = $request->input('number_of_coupons');
        $value = $request->input('value');

        for ($i = 0; $i < $numberOfCoupons; $i++) {
            Coupon::create([
                'code' => $this->generateCouponCode(),
                'is_active' => 1,
                'start_at' => now(),
                'end_at' => null,
                'use_date' => null,
                'user_id' => null,
                'value' => $value,
            ]);
        }

        return redirect()->route('coupons.index')->with('success', 'Coupons generated successfully.');
    }

    private function generateCouponCode()
    {
        return str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public function apply()
    {
        $students = User::where('category', 'student')->get();
        return view('admin.coupons.apply', compact('students'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|exists:coupons,code',
            'user_id' => 'required|exists:users,id',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();
        $user = User::find($request->user_id);

        if (!$coupon->is_active || $coupon->use_date) {
            return redirect()->back()->with('error', 'Coupon is not valid.');
        }

        $user->wallet += $coupon->value;
        $user->save();

        $coupon->is_active = 0;
        $coupon->use_date = now();
        $coupon->user_id = $user->id;
        $coupon->save();

        return redirect()->route('coupons.index')->with('success', 'Coupon applied successfully.');
    }
}
