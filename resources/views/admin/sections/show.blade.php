@extends('layouts.admin')

@section('content')
<style>
    h5 {
        font-weight: 400;
    }
</style>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>عرض القسم</h3>
        </div>
        <div class="card-body">
            <h2>اسم القسم: {{ $section->name }}</h2>
            <br>
            <h5>المحتوى: {{ $section->content }}</h5>
            <h5>الترتيب: {{ $section->order }}</h5>
            <h5>مفعل ام لا: {{ $section->is_active ? 'نعم' : 'لا' }}</h5>
            <br><br>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>الوسائط:</h4>
                <a href="{{ route('media.create', $section->id) }}" class="btn btn-primary">إضافة وسائط</a>
            </div>
            @if (!$section->media->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>المحتوى</th>
                            <th>الترتيب</th>
                            <th>النوع</th>
                            <th>إنشاء في</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->media as $media)
                            <tr>
                                <td>{{ $media->name }}</td>
                                <td>{{ $media->content }}</td>
                                <td>{{ $media->order }}</td>
                                <td>{{ $media->type }}</td>
                                <td>{{ $media->created_at }}</td>
                                <td>
                                    <a href="{{ route('media.show', $media->id) }}" class="btn btn-info btn-sm">عرض</a>
                                    <a href="{{ route('media.edit', $media->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                    <form action="{{ route('media.destroy', $media->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد وسائط متعلقة بهذا القسم.</p>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                <h4>الامتحانات:</h4>
                <a href="{{ route('exam.create', $section->id) }}" class="btn btn-primary">إضافة امتحان</a>
            </div>
            @if (!$section->exam->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الوقت</th>
                            <th>الدرجة</th>
                            <th>درجة النجاح</th>
                            <th>إلزامي</th>
                            <th>إنشاء في</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->exam as $exam)
                            <tr>
                                <td>{{ $exam->name }}</td>
                                <td>{{ $exam->time }}</td>
                                <td>{{ $exam->degree }}</td>
                                <td>{{ $exam->success_degree }}</td>
                                <td>{{ $exam->compulsory ? 'نعم' : 'لا' }}</td>
                                <td>{{ $exam->created_at }}</td>
                                <td>
                                    <a href="{{ route('exam.show', $exam->id) }}" class="btn btn-info btn-sm">عرض</a>
                                    <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                    <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد امتحانات متعلقة بهذا القسم.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('هل تود حذف الفئة الدراسية؟');
    }
</script>

@endsection
