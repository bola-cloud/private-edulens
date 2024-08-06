<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Media;
use App\Models\Exam;
use Carbon\Carbon;
use Auth;

class CoursesController extends Controller
{
    public function index($id)
    {
        Carbon::setLocale('ar');
        $course = Course::with('section.media')->find($id);
        
        $videoCount = 0;
        $fileCount = 0;

        foreach ($course->section as $section) {
            $videoCount += $section->media->where('type', 'video')->count();
            $fileCount += $section->media->where('type', 'file')->count();
        }

        return view('front.course-content', compact('course', 'videoCount', 'fileCount'));
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

    public function subscribe(Request $request)
    {
        $user=Auth::user();
        $course=Course::find($request->course_id);
        if($user&& $user->wallet >= $course->price && $request->paymentMethod =="wallet")
        {
            $user->courses()->attach($course->id);
            $user->update(['wallet' => $user->wallet-=$course->price]);
        }
        elseif($user->wallet < $course->price && $request->paymentMethod =="wallet"){
            return redirect()->back()->with('error','لا يوجد رصيد كافي بالمحفظة');
        }
        return redirect()->back()->with('success','تم شراء الكورس بنجاح');
    }

}
