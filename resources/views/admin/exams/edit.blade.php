@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>تعديل الامتحان</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('exam.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $exam->name }}">
                </div>

                <div class="mb-3">
                    <label for="time" class="form-label">الوقت (بالدقائق)</label>
                    <input type="number" class="form-control" id="time" name="time" value="{{ $exam->time }}">
                </div>

                <div class="mb-3">
                    <label for="degree" class="form-label">الدرجة الكلية</label>
                    <input type="number" class="form-control" id="degree" name="degree" value="{{ $exam->degree }}">
                </div>

                <div class="mb-3">
                    <label for="success_degree" class="form-label">درجة النجاح</label>
                    <input type="number" class="form-control" id="success_degree" name="success_degree" value="{{ $exam->success_degree }}">
                </div>

                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="compulsory" name="compulsory" value="1" {{ $exam->compulsory ? 'checked' : '' }}>
                    <label class="form-check-label" for="compulsory">إلزامي</label>
                    @error('compulsory')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror 
                </div>

                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </form>
        </div>
    </div>
</div>
@endsection
