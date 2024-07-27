<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\Grade;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $courseCategories = CourseCategory::all();
        $grades = Grade::where('is_active',1)->get();
        return view('admin.course_categories.index', compact('courseCategories','grades'));
    }

    public function create()
    {
        $grades = Grade::where('is_active',1)->get();
        return view('admin.course_categories.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => '',
            'grade_id' => 'nullable|exists:grades,id'
        ]);

        CourseCategory::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'grade_id' => $request->grade_id,
        ]);

        return redirect()->route('course_categories.index');
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => '',
            'grade_id' => 'nullable|exists:grades,id'
        ]);

        $courseCategory->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'grade_id' => $request->grade_id,
        ]);

        return redirect()->route('course_categories.index');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        $courseCategory->delete();
        return redirect()->route('course_categories.index');
    }
}
