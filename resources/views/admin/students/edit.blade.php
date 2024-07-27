@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>تعديل الطالب</h1>

    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">اللقب</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $student->last_name }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $student->phone }}" required>
        </div>

        <div class="mb-3">
            <label for="grade_id" class="form-label">الصف</label>
            <select id="grade_id" name="grade_id" class="form-control">
                <option value="">اختر الصف</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $student->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">اترك الحقل فارغًا إذا لم ترغب في تغيير كلمة المرور.</small>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
    </form>
</div>
@endsection
