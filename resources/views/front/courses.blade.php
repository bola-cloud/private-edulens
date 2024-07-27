@extends('layouts.front')

@section('content')
    <style>
        .bg-grey-title{
            background: url('{{asset('media/Subtract.svg')}}') no-repeat center center;
            background-size: contain;
            padding: 20px;
            height: 100px; /* Adjust as needed */
            width: 44vh; /* Adjust as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            color: black;
        }
    </style>
    <div class="container-fluid p-3">
        <div class="d-flex justify-content-center">
            {{-- <img src="{{asset('media/Subtract.svg')}}" class="bg-grey-title" alt=""> --}}
            <h1 class="mt-3 p-4 bg-grey-title"> {{$grade->name}}</h1>
        </div>
        <div class="row p-5">
            @foreach ($categories as $category)
                <div class="col-md-12">
                    <h3 class="text-end pe-5 ps-5"> {{$category->name}} </h3>
                    <br>
                    <div class="row ps-5 pe-5 mt-3">
                        @foreach ($category->courses as $course)
                            <div class="col-md-4">
                                <a href="{{route('course_content',$course->id)}}">
                                    <div class="card bg-dark p-2 card-custom" style="background: none">
                                        <img class="card-img-top" src="{{asset($course->image)}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h2 class="card-title text-end text-light"> {{$grade->name}} </h2>
                                            <h5 class="text-end text-light"><i class="fas fa-book-open"></i> {{$course->section()->count()}} شابتر</h5>
                                        </div>
                                        <div class="card-border card-footer bg-dark">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-4">
                                                    @if($course->price== 0)
                                                    <p> مجاني </p>
                                                    @else
                                                    <p class="fw-bold text-light"> {{$course->price}}  ج.م</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <a href="{{route('courses',$grade->id)}}" class="btn btn-gradient pt-2 pb-2 w-100">
                                                            <span> اشترك الان</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>    
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>

@endsection