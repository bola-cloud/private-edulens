@extends('layouts.front')

@section('content')

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
                                <div class="accordion-item course-content-collapse flex-column w-100 text-light bg-black row ">
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
                                            @if($media->type == "video")
                                                <a href="{{route('video_show',$media->id)}}" class="btn subscribe-btn no-toggle">مشاهدة الفيديو</a>
                                            @elseif($media->type == "file")
                                                <a href="{{ url('/images/media/' . basename($media->path)) }}" class="btn subscribe-btn no-toggle" target="_blank">مشاهدة الملف</a>
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
                                        <a class="btn subscribe-btn no-toggle" data-bs-toggle="modal" data-bs-target="#examModal">الدخول للامتحان</a>
                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="examModalLabel">الامتحان</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <h6 class="text-danger">تعليمات هامة</h6>
                                                <ul>
                                                    <li>الامتحان يفتح مرة واحدة فقط</li>
                                                    <li>عدد الاسئلة: 30 سؤال</li>
                                                    <li>درجة النجاح: 30 درجات</li>
                                                    <li>درجة الامتحان: 30 درجة</li>
                                                    <li>مدة الامتحان: 30 دقيقة</li>
                                                </ul>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                <button type="button" class="btn btn-primary">ابدأ الامتحان</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div> --}}
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
                        <span>4 شابتر</span>
                        <span><i class="fas fa-book"></i></span>
                    </div>
                    <div>
                        <span>20 فيديو</span>
                        <span><i class="fas fa-video"></i></span>
                    </div>
                    <div>
                        <span>12 مذكرة</span>
                        <span><i class="fas fa-sticky-note"></i></span>
                    </div>
                </div>
                <div class="row p-3" style="border-top:2px solid #fcfcfc">
                    <div class="price col-md-4">200 ج م</div>
                    <a href="#" class="btn btn-gradient pt-2 pb-2 col-md-8">اشترك الان</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.no-toggle').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();  // Prevent the default action
                event.stopPropagation(); // Stop the click event from propagating
                // Perform any other desired actions here, such as opening a modal or redirecting
                window.open(this.href, '_blank'); // Example: open the link in a new tab
            });
        });
    });


</script>
@endpush