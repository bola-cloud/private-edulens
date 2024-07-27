@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>تعديل سؤال</h3>
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
            <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان السؤال</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $question->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">صورة (اختياري)</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if ($question->image)
                        <img src="{{ asset($question->image) }}" alt="Image" style="max-width: 200px;" class="mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">الحالة</label><br>
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $question->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">مفعل</label>
                </div>
                <div class="mb-3">
                    <label for="choices" class="form-label">الخيارات</label>
                    <div id="choices">
                        @foreach ($question->choice as $index => $choice)
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="choices[]" value="{{ $choice->choice }}" required>
                                <input type="file" class="form-control" name="choice_images[]">
                                @if ($choice->image)
                                    <img src="{{ asset($choice->image) }}" alt="Image" style="max-width: 100px;" class="mt-2">
                                @endif
                                <div class="input-group-text">
                                    <input class="form-check-input" type="checkbox" name="is_true[]" value="{{ $index }}" {{ $choice->is_true ? 'checked' : '' }}> صحيح
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">تحديث</button>
            </form>
        </div>
    </div>
</div>
@endsection
