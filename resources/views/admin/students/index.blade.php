@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>ادارة الطلاب</h1>

    <form method="GET" action="{{ route('students.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو الهاتف" value="{{ request()->search }}">
            </div>
            <div class="col-md-4">
                <select name="grade" class="form-control">
                    <option value="">كل الصفوف</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ request()->grade == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>اللقب</th>
                <th>الهاتف</th>
                <th>الصف</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ optional($student->grade)->name }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">تعديل</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $students->links() }}
</div>
@endsection
