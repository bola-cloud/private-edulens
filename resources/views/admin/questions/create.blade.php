@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>إضافة سؤال</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('questions.store', $exam_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="exam_id" value="{{ $exam_id }}">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان السؤال</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">صورة (اختياري)</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="mb-3">
                    <label class="form-label">الحالة</label><br>
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active">
                    <label class="form-check-label" for="is_active">مفعل</label>
                </div>
                <div class="mb-3">
                    <label for="choices" class="form-label">الخيارات</label>
                    <div id="choices">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="choices[]" placeholder="الخيار {{ $i + 1 }}" required>
                                <input type="file" class="form-control" name="choice_images[]">
                                <div class="input-group-text">
                                    <input class="form-check-input" type="checkbox" name="is_true[]" value="{{ $i }}"> صحيح
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">إضافة</button>
            </form>
        </div>
    </div>
</div>
@endsection
