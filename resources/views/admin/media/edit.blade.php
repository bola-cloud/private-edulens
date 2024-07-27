@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>تعديل الوسائط</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('media.update', $media->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $media->name }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">المحتوى</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3" required>{{ $media->content }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ $media->order }}" required>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">النوع</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="file" {{ $media->type === 'file' ? 'selected' : '' }}>ملف</option>
                        <option value="video" {{ $media->type === 'video' ? 'selected' : '' }}>فيديو</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="file-input" style="{{ $media->type === 'file' ? '' : 'display: none;' }}">
                    <label for="file" class="form-label">تعديل الملف</label>
                    @if($media->type === 'file' && $media->path)
                        <p>الملف الحالي: <a href="{{ asset($media->path) }}" target="_blank">عرض الملف</a></p>
                    @endif
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="video-input" style="{{ $media->type === 'video' ? '' : 'display: none;' }}">
                    <label for="path" class="form-label">تعديل رابط الفيديو</label>
                    <input type="text" class="form-control @error('path') is-invalid @enderror" id="path" name="path" value="{{ $media->type === 'video' ? $media->path : '' }}">
                    @error('path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePathInput() {
        var type = document.getElementById('type').value;
        if (type === 'file') {
            document.getElementById('file-input').style.display = '';
            document.getElementById('video-input').style.display = 'none';
        } else {
            document.getElementById('file-input').style.display = 'none';
            document.getElementById('video-input').style.display = '';
        }
    }

    document.getElementById('type').addEventListener('change', togglePathInput);

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePathInput();
    });
</script>
@endsection
