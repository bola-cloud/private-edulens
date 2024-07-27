@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة قسم جديد</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sections.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القسم</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">المحتوى</label>
                            <textarea class="form-control" id="content" name="content" required></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control" id="order" name="order" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="course_id" name="course_id" value="{{ $course_id }}" required>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                مفعل ام لا
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePathInput();
    });
</script>
@endsection
