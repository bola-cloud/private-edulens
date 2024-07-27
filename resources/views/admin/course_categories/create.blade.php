@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5> اضافة فئة جديدة للكورسات</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('course_categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الفئة</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="grade_id" class="form-label">الصف الدراسي</label>
                            <select class="form-select" id="grade_id" name="grade_id">
                                <option value="">اختر الصف الدراسي</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                            @error('grade_id')
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
                        <button type="submit" class="btn btn-success">اضافة فئة جديدة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
