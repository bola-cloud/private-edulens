<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Media;
use App\Models\Exam;
use Carbon\Carbon;

class CoursesController extends Controller
{
    public function index($id)
    {
        Carbon::setLocale('ar');
        $course= Course::find($id);
        return view('front.course-content',compact('course'));
    }

    public function video($id)
    {
        $media= Media::find($id);
        $course= Course::find($media->section->course->id);
        // dd($course);
        return view('front.show_video',compact('media','course'));
    }
    public function course($id)
    {
        $exam= Exam::find($id);
        return view('front.course-content',compact('exam'));
    }
}
