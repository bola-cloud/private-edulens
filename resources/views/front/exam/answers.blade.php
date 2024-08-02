@extends('layouts.front')

@section('content')
<div class="container-fluid">
    <h2 class="mt-5">{{ $exam->name }}</h2>
    <div class="row m-5 d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card" style="border-radius: 40px;">
                <div class="card-body">
                    <div class="exam-header">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="question-pagination">
                                    @foreach ($exam->questions as $index => $question)
                                        <button type="button" class="btn pagination-buttons question-nav" data-question-index="{{ $index }}">{{ $index + 1 }}
                                            <span class="unanswered-dot" style="display: none;">•</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="exam-questions">
                        @foreach ($exam->questions as $question)
                            @php
                                $student_choice = $studentChoices->firstWhere('question_id', $question->id);
                                $is_unanswered = !$student_choice || is_null($student_choice->choice_id);
                            @endphp
                            <div class="question" style="display: none;">
                                <div class="row mb-4 p-5">
                                    <div class="col-md-6 question-head">
                                        <h4>السؤال {{ $loop->iteration }}: {{ $question->title }}</h4>
                                    </div>
                                    <div class="col-md-6">
                                        @if($question->image)
                                            <img src="{{ asset($question->image) }}" class="w-100 h-100" alt="Question Image">
                                        @endif
                                    </div>
                                </div>
                                <div class="choices row d-flex justify-content-center">
                                    @foreach ($question->choice as $index => $choice)
                                        @php
                                            $is_correct = $choice->is_true ? 'correct' : '';
                                            $is_selected = $student_choice && $student_choice->choice_id == $choice->id ? 'selected' : '';
                                        @endphp
                                        <label class="choice col-md-2 m-2 p-2 btn btn-outline-secondary {{ $is_correct }} {{ $is_selected }}">
                                            <input type="radio" name="question_{{ $question->id }}" value="{{ $choice->id }}" hidden>
                                            @if($choice->image)
                                                <img src="{{ asset($choice->image) }}" class="w-100" alt="Choice Image">
                                            @endif
                                            <span>{{ $choice->choice }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @if ($is_unanswered)
                                    <div class="unanswered">لم يتم الاجابة علي ذلك السوال</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('course_content',$exam->section->course->id) }}" class="btn subscribe-btn no-toggle col-md-1">خروج</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .question-pagination .btn {
        border-radius: 50%;
        margin: 0 5px;
        padding: 5px 10px;
        position: relative;
    }
    .choices .choice {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
    }
    .choices .choice:hover {
        background-color: #f0f0f0;
    }
    .choices .choice input[type="radio"] {
        display: none;
    }
    .choices .choice img {
        max-width: 220px;
        margin-right: 10px;
    }
    .choices .choice span {
        display: inline-block;
    }
    .choices .choice input[type="radio"]:checked + span {
        font-weight: bold;
    }
    .pagination-buttons:active,
    .pagination-buttons:hover {
        background: #c1a156;
        color: white;
        border-radius: 48px;
    }
    .pagination-buttons {
        background: #e7e7e7;
        color: black;
        border-radius: 48px;
    }
    .active-question {
        background: #c1a156;
        color: white;
        border-radius: 48px;
    }
    .correct {
        background-color: green !important;
        color: white;
    }
    .selected:not(.correct) {
        background-color: red !important;
        color: white;
    }
    .unanswered {
        color: red;
        font-size: 14px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = document.querySelectorAll('.question');
        const questionNavButtons = document.querySelectorAll('.question-nav');
        let currentQuestion = 0;

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
                if (i === index) {
                    questionNavButtons[i].classList.add('active-question');
                } else {
                    questionNavButtons[i].classList.remove('active-question');
                }
            });
            currentQuestion = index;
        }

        document.querySelectorAll('.question-nav').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-question-index'));
                showQuestion(index);
            });
        });

        showQuestion(currentQuestion);
    });
</script>
@endpush
