@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>إضافة وسائط</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">المحتوى</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order') }}" required>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">النوع</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required onchange="togglePathInput()">
                        <option value="">اختر نوع الوسائط</option>
                        <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>ملف</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>فيديو</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3" id="path-container" style="display: none;">
                    <label for="path" class="form-label" id="path-label">المسار</label>
                    <input type="file" class="form-control @error('path') is-invalid @enderror" id="path-file" name="path" style="display: none;">
                    <input type="text" class="form-control @error('path') is-invalid @enderror" id="path-link" name="path" style="display: none;">
                    @error('path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">إضافة</button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePathInput() {
        const type = document.getElementById('type').value;
        const pathContainer = document.getElementById('path-container');
        const pathFile = document.getElementById('path-file');
        const pathLink = document.getElementById('path-link');
        const pathLabel = document.getElementById('path-label');

        if (type === 'file') {
            pathLabel.innerText = 'الملف';
            pathContainer.style.display = 'block';
            pathFile.style.display = 'block';
            pathFile.name = 'path';
            pathLink.style.display = 'none';
            pathLink.name = '';
        } else if (type === 'video') {
            pathLabel.innerText = 'فيديو';
            pathContainer.style.display = 'block';
            pathFile.style.display = 'none';
            pathFile.name = '';
            pathLink.style.display = 'block';
            pathLink.name = 'path';
        } else {
            pathContainer.style.display = 'none';
            pathFile.style.display = 'none';
            pathFile.name = '';
            pathLink.style.display = 'none';
            pathLink.name = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePathInput();
    });
</script>
@endsection
