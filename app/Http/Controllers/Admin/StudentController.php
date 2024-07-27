<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gradeFilter = $request->input('grade');

        $query = User::where('category', 'student');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        if ($gradeFilter) {
            $query->where('grade_id', $gradeFilter);
        }

        $students = $query->paginate(20);
        $grades = Grade::all();

        return view('admin.students.index', compact('students', 'search', 'gradeFilter', 'grades'));
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $grades = Grade::all();

        return view('admin.students.edit', compact('student', 'grades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'grade_id' => 'nullable|exists:grades,id',
        ]);

        $student = User::findOrFail($id);
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->phone = $request->phone;
        $student->grade_id = $request->grade_id;

        if ($request->password) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
