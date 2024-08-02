<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\StudentChoice;
use App\Models\Choice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Auth;

class ExamsController extends Controller
{
    public function exam($id)
    {
        $exam = Exam::with('questions.choice')->find($id);
        $user = Auth::user();
        $completed = $user->exam()->where('exam_id', $id)->first();
        return view('front.exam.open-exam', compact('exam', 'completed'));
    }

    public function submitExam(Request $request, $exam_id)
    {
        $exam = Exam::with(['questions.choice'])->findOrFail($exam_id);
        $user_id = Auth::id();
        $user = Auth::user();
    
        $score = 0;
    
        foreach ($exam->questions as $question) {
            $userAnswer = $request->input('question_' . $question->id);
            $correctChoice = $question->choice->where('is_true', true)->first();
    
            $is_true = 0;
            if ($correctChoice && $correctChoice->id == $userAnswer) {
                $is_true = 1;
                $score++;
            }
    
            // Check if the user already answered this question
            $existingChoice = $user->choices()->wherePivot('question_id', $question->id)->first();
            if (!$existingChoice) {
                // Attach user to choice or record unanswered question
                if ($userAnswer) {
                    $choice = Choice::find($userAnswer);
                    $user->choices()->attach($userAnswer, [
                        'is_true' => $is_true,
                        'question_id' => $choice->question->id,
                        'exam_id' => $exam->id
                    ]);
                } else {
                    // Record unanswered question with null choice_id
                    DB::table('student_choices')->insert([
                        'user_id' => $user_id,
                        'choice_id' => null,
                        'is_true' => 0,
                        'question_id' => $question->id,
                        'exam_id' => $exam->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    
        $totalQuestions = $exam->questions->count();
    
        // Store student exam result
        StudentExam::updateOrCreate(
            ['user_id' => $user_id, 'exam_id' => $exam_id],
            ['student_degree' => $score, 'exam_degree' => $totalQuestions]
        );
    
        return response()->json(['success' => true, 'score' => $score, 'totalQuestions' => $totalQuestions]);
    }
    
    
    

    public function showAnswers($exam_id)
    {
        $exam = Exam::with('questions.choice')->findOrFail($exam_id);
        $user = Auth::user();
        $studentExam = $user->exam()->where('exam_id', $exam_id)->first();
        $studentChoices = DB::table('student_choices')->where('exam_id', $exam_id)->where('user_id', $user->id)->get();
    
        return view('front.exam.answers', compact('exam', 'studentExam', 'studentChoices'));
    }
    
    

    
}
