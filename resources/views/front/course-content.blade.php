@extends('layouts.front')

@section('content')
<style>

</style>
<div class="container-fluid">
    <div class="container-image">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('media/glitch-effect-black-background_53876-129025 1.svg') }}" alt="Background Image">
                <div class="text-overlay">
                    <h4>{{ $course->name }}</h4>
                    <br>
                    <div class="date-info">
                        <div>
                            <span><i class="fas fa-calendar-alt"></i>تاريخ انشاء الكورس</span>
                            <span>{{ \Carbon\Carbon::parse($course->created_at)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span><i class="fas fa-calendar-alt"></i>اخر تحديث للكورس</span>
                            <span>{{ \Carbon\Carbon::parse($course->updated_at)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="course-content">
            <h3>محتوى الكورس</h3>
            <div class="accordion d-flex flex-column" id="courseContentAccordion">
                @foreach($course->section as $key => $section)
                    <div class="accordion-item course-content-collapse flex-column bg-black">
                        <button class="accordion-button bg-dark ps-4 pe-4 pt-3 pb-3 collapsed w-100 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                            <h2 class="accordion-header" id="heading{{$key}}">
                                <span><i class="fas fa-book"></i></span>
                                <span> {{$section->name}} </span>
                            </h2>
                        </button>
                        <div id="collapse{{$key}}" class="accordion-collapse collapse w-100 p-2" aria-labelledby="heading{{$key}}" data-bs-parent="#courseContentAccordion">
                            @foreach($section->media as $index => $media)
                                <div class="accordion-item course-content-collapse flex-column w-100 text-light bg-black row">
                                    <div class="col-md-12 p-0">
                                        <button class="accordion-button bg-dark text-light ps-3 pe-3 pt-2 pb-2 collapsed w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInner{{$key}}{{$index}}" aria-expanded="false" aria-controls="collapseInner{{$key}}{{$index}}">
                                            <h2 class="accordion-header" id="headingInner{{$key}}{{$index}}">
                                                @if($media->type == "video")
                                                    <span><i class="fas fa-video"></i></span>
                                                @elseif($media->type == "file")
                                                    <span><i class="fas fa-sticky-note"></i></span>
                                                @endif 
                                                <span> {{$media->name}} </span>
                                            </h2>
                                            @if (Auth::check())
                                                @if (!Auth::user()->courses()->where('course_id',$course->id)->exists())
                                                    @if($media->type == "video")
                                                        <a href="{{route('video_show',$media->id)}}" class="btn subscribe-btn no-toggle">مشاهدة الفيديو</a>
                                                    @elseif($media->type == "file")
                                                        <a href="{{ url('/images/media/' . basename($media->path)) }}" class="btn subscribe-btn no-toggle" target="_blank">مشاهدة الملف</a>
                                                    @endif 
                                                @endif
                                            @endif
                                        </button>
                                    </div>
                                    
                                    <div id="collapseInner{{$key}}{{$index}}" class="accordion-collapse collapse w-100 text-justify" aria-labelledby="headingInner{{$key}}{{$index}}" data-bs-parent="#collapse{{$key}}">
                                        <div class="accordion-body text-light w-100 nested-accordion">
                                            {{$media->content}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        
                            @foreach($section->exam as $inc => $exam)
                                <div class="accordion-item course-content-collapse flex-column w-100 text-light bg-black">
                                    <button class="accordion-button bg-dark text-light ps-3 pe-3 pt-2 pb-2 collapsed w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInner{{$key}}{{$inc}}{{$inc}}" aria-expanded="false" aria-controls="collapseInner{{$key}}{{$inc}}{{$inc}}">
                                        <h2 class="accordion-header" id="headingInner{{$key}}{{$inc}}{{$inc}}">
                                            <span><i class="fas fa-sticky-note"></i></span>
                                            <span> {{$exam->name}} </span>
                                        </h2>
                                        @if (Auth::check())
                                            @if (!Auth::user()->courses()->where('course_id',$course->id)->exists())
                                                    <a type="button" class="btn subscribe-btn open-modal" data-bs-toggle="modal" data-bs-target="#examModal" 
                                                    data-exam-id="{{ $exam->id }}"
                                                    data-exam-name="{{ $exam->name }}"
                                                    data-exam-questions="{{ $exam->questions()->count() }}"
                                                    data-exam-degree="{{ $exam->degree }}"
                                                    data-exam-time="{{ $exam->time }}">الدخول للامتحان</a>
                                            @endif
                                        @endif
                                       
                                    </button>
                                    <div id="collapseInner{{$key}}{{$inc}}{{$inc}}" class="accordion-collapse collapse w-100 text-justify" aria-labelledby="headingInner{{$key}}{{$inc}}{{$inc}}" data-bs-parent="#collapse{{$key}}">
                                        <div class="accordion-body text-light w-100 nested-accordion">
                                            <p> عدد الاسئلة : {{$exam->questions()->count()}}سؤال </p>
                                            <p> الدرجة : {{$exam->degree}} درجة </p>
                                            <p>  درجة النجاح: {{$exam->degree}} درجة</p>
                                            <p>  وقت الامتان : {{$exam->time}} دقيقة</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="course-card bg-dark p-1">
            <img src="{{ asset('media/WhatsApp Image 2024-07-02 at 2.03.27 PM 1.svg') }}" alt="Course Image">
            <div class="course-details">
                <h2>{{ $course->name }}</h2>
                <p>{{ $course->description }}</p>
                <div class="course-content-card">
                    <div>
                        <span>{{$course->section()->count()}} شابتر</span>
                        <span><i class="fas fa-book"></i></span>
                    </div>
                    <div>
                        <span>{{$videoCount}} فيديو</span>
                        <span><i class="fas fa-video"></i></span>
                    </div>
                    <div>
                        <span>{{$fileCount}} مذكرة</span>
                        <span><i class="fas fa-sticky-note"></i></span>
                    </div>
                </div>
                @if(Auth::check())
                    @if(!Auth::user()->courses()->where('course_id',$course->id)->exists())
                        <div class="row p-3" style="border-top:2px solid #fcfcfc">
                            <div class="price col-md-4">{{$course->price}} ج م</div>
                            <a href="#" class="btn btn-gradient pt-2 pb-2 col-md-8" data-bs-toggle="modal" data-bs-target="#purchaseModal">اشترك الان</a>
                        </div>
                    @endif
                @else
                    <div class="row p-3" style="border-top:2px solid #fcfcfc">
                        <div class="price col-md-4">{{$course->price}} ج م</div>
                        <a href="{{route('login')}}" class="btn btn-gradient pt-2 pb-2 col-md-8">اشترك الان</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-radius bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">شراء الكورس</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Payment Method -->
                    <div class="mb-3">
                        <label class="form-label d-flex">طريقة الدفع</label>
                        <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="wallet">المحفظة</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="wallet" value="wallet" checked>
                        </div>
                        <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="bayMob">باي موب</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="bayMob" value="bayMob">
                        </div>
                        {{-- <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="code">كود</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="code" value="code">
                        </div> --}}
                    </div>

                    <!-- Payment Code -->
                    <div class="mb-3" id="paymentCodeDiv" style="display: none;">
                        <label class="form-label">كود</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-white" placeholder="أدخل كود الدفع">
                            <button class="btn btn-confirm" type="button">تأكيد</button>
                        </div>
                    </div>

                    <!-- Discount Code -->
                    <div class="mb-3">
                        <label class="form-label">كود الخصم</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-white" placeholder="كود الخصم">
                            <button class="btn btn-apply" type="button">تطبيق</button>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="mb-3">
                        <p> سعر الكورس: <span class="text-beige"> {{$course->price}} ج.م </span></p>
                        <p> الخصم: <span class="text-beige"> 0 ج.م </span></p>
                        <p> الإجمالي: <span class="text-beige"> 200 ج.م </span> </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-gradient pt-2 pb-2 w-100">تأكيد</button>
            </div>
        </div>
    </div>
</div>


<!-- Exam Modal -->
<div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-radius bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="examModalLabel">الامتحان</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-danger">تعليمات هامة</h6>
                <ul>
                    <li>الامتحان يفتح مرة واحدة فقط</li>
                    <li>عدد الاسئلة: <span id="exam-questions">30</span> سؤال</li>
                    <li>درجة النجاح: <span id="exam-degree">30</span> درجات</li>
                    <li>درجة الامتحان: <span id="exam-degree">30</span> درجة</li>
                    <li>مدة الامتحان: <span id="exam-time">30</span> دقيقة</li>
                </ul>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <a href="#" id="start-exam-button" class="btn btn-gradient pt-2 pb-2 col-md-8">ابدأ الامتحان</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
        const paymentCodeDiv = document.getElementById('paymentCodeDiv');

        paymentMethods.forEach((method) => {
            method.addEventListener('change', function () {
                if (this.value === 'code') {
                    paymentCodeDiv.style.display = 'block';
                } else {
                    paymentCodeDiv.style.display = 'none';
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.no-toggle').forEach(function(element) {
            element.addEventListener('click', function(event) {
                if (!element.classList.contains('open-modal')) {
                    event.preventDefault();  // Prevent the default action
                    event.stopPropagation(); // Stop the click event from propagating
                    window.open(this.href, '_blank'); // Example: open the link in a new tab
                }
            });
        });

        document.querySelectorAll('.open-modal').forEach(function(element) {
            element.addEventListener('click', function() {
                var examId = element.getAttribute('data-exam-id');
                var examName = element.getAttribute('data-exam-name');
                var examQuestions = element.getAttribute('data-exam-questions');
                var examDegree = element.getAttribute('data-exam-degree');
                var examTime = element.getAttribute('data-exam-time');

                document.getElementById('examModalLabel').innerText = examName;
                document.getElementById('exam-questions').innerText = examQuestions;
                document.querySelectorAll('#exam-degree').forEach(function(el) {
                    el.innerText = examDegree;
                });
                document.getElementById('exam-time').innerText = examTime;
                document.getElementById('start-exam-button').setAttribute('href', '/course/content/exam/' + examId);
            });
        });
    });
</script>
@endpush
