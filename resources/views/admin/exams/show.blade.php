@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h3>عرض الامتحان</h3>
        </div>
        <div class="card-body">
            <h4>اسم الامتحان: {{ $exam->name }}</h4>
            <p>الوقت: {{ $exam->time }} دقائق</p>
            <p>الدرجة: {{ $exam->degree }}</p>
            <p>درجة النجاح: {{ $exam->success_degree }}</p>
            <p>إلزامي: {{ $exam->compulsory ? 'نعم' : 'لا' }}</p>

            <a href="{{ route('questions.create', $exam->id) }}" class="btn btn-primary">إضافة سؤال</a>
            <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-warning">تعديل</a>
            <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">حذف</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>الأسئلة</h3>
        </div>
        <div class="card-body">
            @if (!$exam->questions->isEmpty())
                @foreach ($exam->questions as $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>{{ $question->title }}</h4>
                            @if ($question->image)
                                <img src="{{ asset($question->image) }}" alt="Image" style="max-width: 200px;" class="mb-3">
                            @endif
                            <ul class="list-unstyled">
                                @foreach ($question->choice as $index => $choice)
                                    <li class="mb-2">
                                        <span>{{ $index + 1 }}. {{ $choice->choice }}</span>
                                        @if ($choice->image)
                                            <br><img src="{{ asset($choice->image) }}" alt="Image" style="max-width: 100px;">
                                        @endif
                                        @if ($choice->is_true)
                                            <span class="badge bg-success ms-2">صحيح</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>لا توجد أسئلة متعلقة بهذا الامتحان.</p>
            @endif

        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('هل تود حذف هذا الامتحان؟');
    }
</script>
@endsection
