@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل القسم</h5>
                </div>
                <div class="card-body">
                    <form id="editSectionForm" action="{{ route('sections.update', $section->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القسم</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $section->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">المحتوى</label>
                            <textarea class="form-control" id="content" name="content" required>{{ $section->content }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control" id="order" name="order" value="{{ $section->order }}" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">النوع</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="media" {{ $section->type == 'media' ? 'selected' : '' }}>وسائط</option>
                                <option value="exam" {{ $section->type == 'exam' ? 'selected' : '' }}>امتحان</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="course_id" name="course_id" value="{{ $section->course_id }}" required>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $section->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                مفعل ام لا
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const originalType = typeSelect.value;

        typeSelect.addEventListener('change', function (event) {
            const confirmed = confirm('تغيير نوع القسم سيؤدي إلى حذف العلاقة الموجودة مع الوسائط أو الامتحانات الحالية. هل أنت متأكد من المتابعة؟');
            if (!confirmed) {
                typeSelect.value = originalType;
            }
        });
    });
</script>
@endsection
