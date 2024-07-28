<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\StudentChoice;
use Illuminate\Support\Facades\Log;
use Auth;

class ExamsController extends Controller
{
    public function exam($id)
    {
        $exam = Exam::with('questions.choice')->find($id);
        return view('front.exam.open-exam', compact('exam'));
    }

    public function submitExam(Request $request, $exam_id)
    {
        $exam = Exam::with(['questions.choice'])->findOrFail($exam_id);
        $totalQuestions = $exam->questions->count();
        $user_id = Auth::id();
        $user = Auth::user();

        // Log the received answers
        Log::info('User ID: ' . $user_id);
        Log::info('Exam ID: ' . $exam_id);
        Log::info('Received answers: ', $request->all());

        foreach ($exam->questions as $question) {
            $userAnswer = $request->input('question_' . $question->id);
            $correctChoice = $question->choice->where('is_correct', true)->first();

            $is_true = ($correctChoice && $correctChoice->id == $userAnswer) ? 1 : 0;

            // Log each question's answer and correctness
            Log::info('Question ID: ' . $question->id . ', User Answer: ' . $userAnswer . ', Is Correct: ' . $is_true);

            // Attach user to choice
            $user->choices()->attach($userAnswer, ['is_true' => $is_true]);
        }

        // Calculate the score based on the number of correct answers
        $correctAnswers = StudentChoice::where('user_id', $user_id)
            ->whereHas('question', function($query) use ($exam_id) {
                $query->where('exam_id', $exam_id);
            })
            ->where('is_true', 1)
            ->count();

        // Each question is worth 1 point, so the final score is the number of correct answers
        $score = $correctAnswers;

        // Log the final score
        Log::info('Final Score: ' . $score);

        // Store student exam result
        StudentExam::create([
            'user_id' => $user_id,
            'exam_id' => $exam_id,
            'student_degree' => $score,
            'exam_degree' => $totalQuestions, // Total possible score is the total number of questions
        ]);

        return view('front.exam.result', compact('exam', 'score', 'totalQuestions', 'correctAnswers'));
    }
}
