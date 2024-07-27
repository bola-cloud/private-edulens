<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = CourseCategory::where('is_active',1)->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Max 2MB, can be adjusted as needed
            'price' => 'required|integer',
            'order' => 'required|integer',
            'type' => 'required|in:center,online,all',
            'category_id' => 'required|exists:course_categories,id',
        ]);

        $courseData = $request->only(['name', 'content', 'price', 'order', 'type', 'category_id']);
        $courseData['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $path = $request->file('image')->move(public_path('images/courses'), $filename);
            $courseData['image'] = 'images/courses/' . $filename;
        }

        Course::create($courseData);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $course=Course::find($id);
        return view('admin.courses.show',['course'=>$course]);
    }



}
