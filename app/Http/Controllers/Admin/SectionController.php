<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Section;
use App\Models\Course;
use Illuminate\Http\Request;

class SectionController extends Controller
{


    public function create($id)
    {
        $course_id = $id; // Assuming you have a Course model
        return view('admin.sections.create', compact('course_id'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
            'is_active' => '',
            'course_id' => 'nullable|exists:courses,id',
        ]);
    
        $sectionData = $request->only(['name', 'content', 'order', 'type', 'course_id']);
        $sectionData['is_active'] = $request->has('is_active');
    
        Section::create($sectionData);
    
        return redirect()->route('courses.show',$request->course_id)->with('success', 'Section created successfully.');
    }
    
    public function edit($id)
    {
        $section = Section::findOrFail($id);
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer',
            'is_active' => '',
            'type' => 'required|in:media,exam',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $section = Section::findOrFail($id);
        $originalType = $section->type;

        $sectionData = $request->only(['name', 'content', 'order', 'type', 'course_id']);
        $sectionData['is_active'] = $request->has('is_active');

        if ($originalType !== $request->type) {
            // If the type has changed, delete related media or exam
            if ($originalType === 'media') {
                $section->media()->delete();
            } elseif ($originalType === 'exam') {
                $section->exam()->delete();
            }
        }

        $section->update($sectionData);

        return redirect()->route('courses.show', $section->course_id)->with('success', 'Section updated successfully.');
    }

    public function show($id)
    {
        $section = Section::findOrFail($id);
        $relatedContent = collect(); // Initialize as an empty collection

        if ($section->type == 'media') {
            $relatedContent = $section->media; // Fetch media related to this section
        } else if ($section->type == 'exam') {
            $relatedContent = $section->exam; // Fetch exams related to this section
        }

        return view('admin.sections.show', compact('section', 'relatedContent'));
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->back()->with('success', 'Section deleted successfully.');
    }

}
