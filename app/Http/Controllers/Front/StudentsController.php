<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Governorate;
use App\Models\Transaction;
use App\Models\Grade;
use Auth;

class StudentsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd($user->exam);
        $governorates = Governorate::all();
        $grades = Grade::where('is_active', 1)->get();
        $transactions = Transaction::where('user_id',$user->id)->with('user')->get();
        return view('front.student-profile',compact('governorates','grades','transactions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'parent_phone' => 'nullable|string|max:15',
            'gender' => 'required|string|in:ذكر,انثي',
            'grade_id' => 'required|integer',
            'governorate_id' => 'required|integer',
            'type' => 'required|string|in:center,online',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'last_name.required' => 'حقل الاسم الأخير مطلوب.',
            'last_name.string' => 'حقل الاسم الأخير يجب أن يكون نص.',
            'last_name.max' => 'حقل الاسم الأخير يجب أن لا يزيد عن 255 حرف.',

            'name.required' => 'حقل الاسم الأول مطلوب.',
            'name.string' => 'حقل الاسم الأول يجب أن يكون نص.',
            'name.max' => 'حقل الاسم الأول يجب أن لا يزيد عن 255 حرف.',

            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'حقل رقم الهاتف يجب أن يكون نص.',
            'phone.max' => 'حقل رقم الهاتف يجب أن لا يزيد عن 15 حرف.',

            'parent_phone.string' => 'حقل رقم هاتف ولي الأمر يجب أن يكون نص.',
            'parent_phone.max' => 'حقل رقم هاتف ولي الأمر يجب أن لا يزيد عن 15 حرف.',

            'gender.required' => 'حقل الجنس مطلوب.',
            'gender.in' => 'حقل الجنس يجب أن يكون إما "ذكر" أو "انثي".',

            'grade_id.required' => 'حقل الصف مطلوب.',
            'grade_id.integer' => 'حقل الصف يجب أن يكون رقم صحيح.',

            'governorate_id.required' => 'حقل المحافظة مطلوب.',
            'governorate_id.integer' => 'حقل المحافظة يجب أن يكون رقم صحيح.',

            'type.required' => 'حقل النوع مطلوب.',
            'type.string' => 'حقل النوع يجب أن يكون نص.',
            'type.max' => 'حقل النوع يجب أن لا يزيد عن 255 حرف.',

        ]);

        try {
            $user = Auth::user();
            $user->last_name = $request->input('last_name');
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->parent_phone = $request->input('parent_phone');
            $user->gender = $request->input('gender');
            $user->grade_id = $request->input('grade_id');
            $user->governorate_id = $request->input('governorate_id');
            $user->type = $request->input('type');

            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'nullable|string|min:8|confirmed',
                ],[
                    'password.nullable' => 'حقل كلمة المرور اختياري.',
                    'password.string' => 'حقل كلمة المرور يجب أن يكون نص.',
                    'password.min' => 'حقل كلمة المرور يجب أن لا يقل عن 8 حروف.',
                    'password.confirmed' => 'حقل تأكيد كلمة المرور غير متطابق مع كلمة المرور.',
                ]);
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الملف الشخصي. الرجاء المحاولة مرة أخرى.');
        }
    }

}
