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
                            <div class="col-md-3">
                                <div class="exam-timer text-danger">
                                    <span>الوقت المتبقي: <span id="exam-timer">{{ $exam->time }}:00</span></span>
                                </div>
                            </div>
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
                    <form id="exam-form" action="{{ route('exam.submit', $exam->id) }}" method="POST">
                        @csrf
                        <div class="exam-questions">
                            @foreach ($exam->questions as $question)
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
                                            <label class="choice col-md-2 m-2 p-2 btn btn-outline-secondary">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ $choice->id }}" hidden>
                                                @if($choice->image)
                                                    <img src="{{ asset($choice->image) }}" class="w-100" alt="Choice Image">
                                                @endif
                                                <span>{{ $choice->choice }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                
                        <div class="exam-navigation d-flex justify-content-start mt-4">
                            <button type="button" class="btn next-back ps-3 pe-3" id="prev-question">السابق</button>
                            <button type="button" class="btn ms-3 me-3 next-back ps-3 pe-3" id="next-question">التالي</button>
                            <button type="submit" class="btn btn-beige ps-4 pe-4 pt-2 pb-2" id="finish-exam">إنهاء الامتحان</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentQuestion = 0;
        const questions = document.querySelectorAll('.question');
        const timerElement = document.getElementById('exam-timer');
        const questionNavButtons = document.querySelectorAll('.question-nav');
        const answers = {};

        let timer = localStorage.getItem('exam_timer_{{ $exam->id }}') ? parseInt(localStorage.getItem('exam_timer_{{ $exam->id }}')) : {{ $exam->time }} * 60;

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

        function updateTimer() {
            const minutes = Math.floor(timer / 60);
            const seconds = timer % 60;
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timer > 0) {
                timer--;
                localStorage.setItem('exam_timer_{{ $exam->id }}', timer);
            } else {
                clearInterval(timerInterval);
                submitExam();
            }
        }

        function submitExam() {
            localStorage.removeItem('exam_timer_{{ $exam->id }}');
            document.getElementById('exam-form').submit();
        }

        function validateForm() {
            let isValid = true;
            questions.forEach((question, index) => {
                const choices = question.querySelectorAll('input[type="radio"]');
                const isAnswered = Array.from(choices).some(choice => choice.checked);
                if (!isAnswered) {
                    isValid = false;
                    questionNavButtons[index].querySelector('.unanswered-dot').style.display = 'inline';
                } else {
                    questionNavButtons[index].querySelector('.unanswered-dot').style.display = 'none';
                }
            });
            return isValid;
        }

        document.getElementById('prev-question').addEventListener('click', function() {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        });

        document.getElementById('next-question').addEventListener('click', function() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        });

        document.getElementById('finish-exam').addEventListener('click', function(event) {
            event.preventDefault();
            if (validateForm()) {
                submitExam();
            } else {
                alert('Please answer all questions before submitting the exam.');
            }
        });

        document.querySelectorAll('.question-nav').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-question-index'));
                showQuestion(index);
            });
        });

        showQuestion(currentQuestion);
        const timerInterval = setInterval(updateTimer, 1000);

        document.querySelectorAll('.choices .choice').forEach(choice => {
            choice.addEventListener('click', function() {
                const radioInput = this.querySelector('input[type="radio"]');
                const questionId = radioInput.name.split('_')[1];
                answers[questionId] = radioInput.value;
                radioInput.checked = true;
                document.querySelectorAll('.choices .choice').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                validateForm();
            });
        });

        // Restore selected choices when navigating back to questions
        document.querySelectorAll('.choices .choice input[type="radio"]').forEach(radioInput => {
            const questionId = radioInput.name.split('_')[1];
            if (answers[questionId] && answers[questionId] == radioInput.value) {
                radioInput.checked = true;
                radioInput.closest('.choice').classList.add('active');
            }
        });
    });
</script>
@endpush

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
    /* .choices .choice.active {
        background-color: #28a745;
        color: #fff;
    } */
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
    .unanswered-dot {
        color: red;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 20px;
    }
</style>
@endpush
