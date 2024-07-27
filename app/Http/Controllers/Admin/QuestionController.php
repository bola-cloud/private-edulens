<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function create($exam_id)
    {
        return view('admin.questions.create', compact('exam_id'));
    }

    public function store(Request $request, $exam_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'choices' => 'required|array|min:4|max:4',
            'choices.*' => 'required|string|max:255',
            'choice_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_true' => 'required|array|min:1|max:4',
            'is_true.*' => 'integer|min:0|max:3',
            'is_active' => 'nullable',
        ],[
            'choices.*.max' => 'يجب ان عدد الاختيارات 4',
            'is_true.*.max' => 'يجب اخيار الاجابة الصحيحة',
        ]);

        try {
            $question = new Question();
            $question->title = $request->title;
            $question->exam_id = $exam_id;
            $question->is_active = $request->has('is_active');

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('questions', $imageName, 'public_images');
                $question->image ='images/questions/'. $imageName;
            }

            $question->save();

            foreach ($request->choices as $index => $choiceText) {
                $choice = new Choice();
                $choice->choice = $choiceText;
                $choice->question_id = $question->id;
                $choice->is_true = in_array($index, $request->is_true);

                if ($request->hasFile("choice_images.$index")) {
                    $choiceImageName = time().'_'.$index.'.'.$request->file("choice_images.$index")->extension();
                    $request->file("choice_images.$index")->storeAs('choices', $choiceImageName, 'public_images');
                    $choice->image = 'images/choices/'. $choiceImageName;
                }

                $choice->save();
            }

            return redirect()->route('exam.show', $exam_id)->with('success', 'Question added successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while adding the question. Please try again.']);
        }
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'choices' => 'required|array|min:4|max:4',
            'choices.*' => 'required|string|max:255',
            'choice_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_true' => 'required|array|min:1|max:4',
            'is_true.*' => 'integer|min:0|max:3',
            'is_active' => 'nullable',
        ]);
    
        try {
            $question = Question::findOrFail($id);
            $question->title = $request->title;
            $question->is_active = $request->has('is_active');
    
            // Update question image if a new one is uploaded
            if ($request->hasFile('image')) {
                if ($question->image) {
                    Storage::disk('public_images')->delete(str_replace('images/', '', $question->image));
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('questions', $imageName, 'public_images');
                $question->image = 'images/questions/'.$imageName;
            }
    
            $question->save();
    
            foreach ($request->choices as $index => $choiceText) {
                $choice = $question->choice[$index];
                $choice->choice = $choiceText;
                $choice->is_true = in_array($index, $request->is_true);
    
                // Update choice image if a new one is uploaded
                if ($request->hasFile("choice_images.$index")) {
                    if ($choice->image) {
                        Storage::disk('public_images')->delete(str_replace('images/', '', $choice->image));
                    }
                    $choiceImageName = time().'_'.$index.'.'.$request->file("choice_images.$index")->extension();
                    $request->file("choice_images.$index")->storeAs('choices', $choiceImageName, 'public_images');
                    $choice->image = 'images/choices/'.$choiceImageName;
                }
    
                $choice->save();
            }
    
            return redirect()->route('exam.show', $question->exam_id)->with('success', 'Question updated successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the question. Please try again.']);
        }
    }
    
    

    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);

            if ($question->image) {
                Storage::disk('public_images')->delete(str_replace('images/', '', $question->image));
            }

            foreach ($question->choice as $choice) {
                if ($choice->image) {
                    Storage::disk('public_images')->delete(str_replace('images/', '', $choice->image));
                }
                $choice->delete();
            }

            $question->delete();

            return redirect()->route('exam.show', $question->exam_id)->with('success', 'Question deleted successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while deleting the question. Please try again.']);
        }
    }

}
