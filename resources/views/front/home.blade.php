@extends('layouts.front')

@section('content')
<div class="main-panel">
    <div class="container-fluid ps-5 pe-5">
        <div class="row">
            <div class="col-md-6 d-flex flex-wrap align-content-center ps-5 pe-5">
                <div class="row col-md-12 mt-4">
                    <h1 class="text-end p-4"> أ / محمود عبدالمرضي </h1>
                </div>
                <br>
                <div class="row col-md-12 mt-4 ">
                    <h3 class="text-end p-4 bg-grey"> مدرس اللغة العربية </h3>
                </div>
                <div class="row col-md-5 mt-4 mb-4">
                    <div class="gray-radius ps-4 pe-4 pt-2 pb-2 d-flex">
                        <div class="gray-images">
                            <img src="{{asset('media/unsplash_kVg2DQTAK7c.svg')}}" alt="">
                            <img src="{{asset('media/unsplash_0fN7Fxv1eWA.svg')}}" alt="">
                            <img src="{{asset('media/unsplash_XHVpWcr5grQ.svg')}}" alt="">
                        </div>
                        <h5 class="d-flex align-content-center flex-wrap">
                            + 20k
                            طالب        
                        </h5>
                    </div>
                </div>
                <div class="row col-md-12 mt-4 mb-4">
                    <div class="button-size text-end">
                        <a href="" class="btn btn-beige ps-5 pe-5 pt-2 pb-2"> اشترك الان </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 half-bg">
                <img src="{{asset('media/Frame 1171278992.svg')}}" class="" alt="">
            </div>
        </div>
    </div>
</div>
<div class="grades p-5">
    <div class="row mt-4">
        <h1> الصفوف الدراسية </h1>
    </div>
    <div class="row p-5">
        @foreach ($grades as $grade)
            <div class="col-md-4">
                <div class="card bg-dark" style="background: none">
                    <img class="card-img-top" src="{{asset('media/school-elements-background-hand-drawn-style_23-2147769231 1.svg')}}" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title text-end text-light"> {{$grade->name}} </h2>
                    </div>
                    <div class="card-border card-footer bg-dark">
                        <a href="{{route('courses',$grade->id)}}" class="btn d-flex justify-content-between btn-beige pe-5 pt-2 pb-2 w-100">
                            <span> مشاهدة المزيد </span>
                            <i class="fas fa-chevron-left mt-2 ms-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection