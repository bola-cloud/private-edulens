<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Course;
use App\Models\CourseCategory;

class HomeController extends Controller
{
    public function index()
    {
        $grades = Grade::where('is_active',1)->get();
        return view('front.home',compact('grades'));
    }
    public function courses($id)
    {
        $grade=Grade::find($id);
        $categories = CourseCategory::where('is_active',1)->where('grade_id',1)->with('courses','courses.section')->get();
        return view('front.courses',compact('categories','grade'));
    }
}
