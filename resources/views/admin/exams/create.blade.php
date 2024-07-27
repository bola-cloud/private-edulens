@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>إضافة امتحان</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('exam.store') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">الوقت (بالدقائق)</label>
                    <input type="number" class="form-control" id="time" name="time" required>
                </div>
                <div class="mb-3">
                    <label for="degree" class="form-label">الدرجة</label>
                    <input type="number" class="form-control" id="degree" name="degree" required>
                </div>
                <div class="mb-3">
                    <label for="success_degree" class="form-label">درجة النجاح</label>
                    <input type="number" class="form-control" id="success_degree" name="success_degree" required>
                </div>
                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="compulsory" name="compulsory">
                    <label class="form-check-label" for="compulsory">إلزامي</label>
                </div>
                <button type="submit" class="btn btn-primary">إضافة</button>
            </form>
        </div>
    </div>
</div>
@endsection
