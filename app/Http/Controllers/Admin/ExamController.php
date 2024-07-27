<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Exam;

class ExamController extends Controller
{
    public function create($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        return view('admin.exams.create', compact('section'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|integer',
            'degree' => 'required|integer',
            'success_degree' => 'required|integer',
            'compulsory' => 'nullable',
            'section_id' => 'required|exists:sections,id',
        ]);
    
        $data = $request->all();
        $data['compulsory'] = $request->has('compulsory') ? 1 : 0;
    
        Exam::create($data);
    
        return redirect()->route('sections.show', $request->section_id)->with('success', 'Exam added successfully');
    }
    

    public function editExam($id)
    {
        $exam = Exam::findOrFail($id);
        // You can add any additional logic here if needed
        return view('admin.exams.edit', compact('exam'));
    }

    public function updateExam(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
    
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|integer',
            'degree' => 'required|integer',
            'success_degree' => 'required|integer',
            'compulsory' => 'boolean',
        ]);
    
        // Update the exam data
        $exam->update([
            'name' => $request->input('name'),
            'time' => $request->input('time'),
            'degree' => $request->input('degree'),
            'success_degree' => $request->input('success_degree'),
            'compulsory' => $request->has('compulsory') ? 1 : 0,
        ]);
    
        return redirect()->back()->with('success', 'تم تحديث الامتحان بنجاح.');
    }
    
    public function show($id)
    {
        $exam = Exam::with('questions.choice')->findOrFail($id);
        return view('admin.exams.show', compact('exam'));
    }

    public function deleteExam($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'تم حذف الامتحان بنجاح.');
    }

}
