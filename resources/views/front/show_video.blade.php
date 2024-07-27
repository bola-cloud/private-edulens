@extends('layouts.front')

@section('content')

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            @php
                $youtubeUrl = $media->path;
                $videoId = last(explode('/', parse_url($youtubeUrl, PHP_URL_PATH)));
                $embedUrl = "https://www.youtube.com/embed/" . $videoId;
            @endphp

            <iframe src="{{ $embedUrl }}" class="w-100 h-100" style="min-height: 540px; max-width:1120px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        </div>
    </div>
    <div class="row mb-5 d-flex justify-content-center">
        <div class="col-md-9 course-content p-0">
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
    </div>
</div>

@endsection