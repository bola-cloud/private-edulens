@extends('layouts.admin')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center mr-5">
        <div class="col-md-11">
            <div class="row d-flex justify-content-center" >
                <div class="col-md-6 card p-0" style="">
                    <img src="{{asset($course->image)}}" class="w-100 h-100"
                     style="border-radius: 20px;border: solid 2px #0000ff36;" alt="">
                </div>
                <div class="col-md-5 p-5" style="font-family: cursive;">
                    <h2>{{$course->name}}</h2>
                    <h5>المحتوي: {{$course->content}}</h5>
                    <h5 class="text-danger"> سعر الكورس :{{$course->price}} ج.م</h5>
                    <h5> الفئة : {{$course->category->name}}</h5>
                    <h5> الترتيب : {{$course->order}}</h5>
                    <h5> مفعل ام لا : {{$course->is_active ? 'نعم' : 'لا'}}</h5>

                    <h5> انشاء في : {{$course->created_at}}</h5>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-5 mb-5">
                <div class="col-md-12 d-flex justify-content-center card">
                    <div class="card-header d-flex justify-content-between align-items-center mt-3">
                        <h3>الاقسام</h3>
                        <a href="{{ route('sections.create',$course->id) }}" class="btn btn-primary mb-3">اضافة قسم</a>
                    </div>
                    <table class="table mb-5">
                        <thead>
                            <tr>
                                <th scope="col">الاسم</th>
                                <th scope="col">المحتوي</th> 
                                <th scope="col">الترتيب</th>
                                <th scope="col">مفعل ام لا</th>
                                <th scope="col">انشاء في</th>
                                <th scope="col">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->section as $section)
                                <tr>
                                    <td>{{$section->name}}</td>
                                    <td>{{$section->content}}</td>
                                    <td>{{$section->order}}</td>
                                    <td>{{$section->is_active ? 'نعم' : 'لا'}}</td>
                                    <td>{{$section->created_at}}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('sections.show', $section->id) }}" class="btn btn-info btn-sm">عرض</a>
                                        <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-warning btn-sm ms-3 me-3">تعديل</a>
                                        <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>      
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('هل تود حذف الفئة الدراسية؟');
    }
</script>

@endsection
