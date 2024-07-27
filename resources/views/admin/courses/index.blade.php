@extends('layouts.admin')

@section('content')
<style>
    .table td img{
        width: 50px;
        height: 50px;
    }
</style>
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-10 card">
            <div class="card-header d-flex justify-content-between align-items-center mt-3">
                <h3>الكورسات</h3>
                <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3"> اضافة كورس جديد </a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>اسم الكورس</th>
                        <th>المحتوي</th>
                        <th>الصورة</th>
                        <th>السعر</th>
                        <th>الترتيب</th>
                        <th>نوع الكورس</th>
                        <th>فئة الكورس</th>
                        <th>مفعل ام لا</th>
                        <th>الاجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->content }}</td>
                        <td><img src="{{ asset($course->image) }}" alt="{{ $course->name }}" style="max-width: 150px;"></td>
                        <td>{{ $course->price }}</td>
                        <td>{{ $course->order }}</td>
                        <td>{{ $course->type }}</td>
                        <td>{{ $course->category->name ?? 'N/A' }}</td>
                        <td>{{ $course->is_active ? 'نعم ' : 'لا' }}</td>
                        <td>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">عرض</a>
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
