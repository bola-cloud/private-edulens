@extends('layouts.admin')

@section('content')

    <div class="container-fluid mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5> ادارة فئات الكورسات </h5>
                        <a href="{{ route('course_categories.create') }}" class="btn btn-success">اضافة فئة الكورسات</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>اسم الفئة</th>
                                <th>مفعل ام لا</th>
                                <th>الصف الدراسي</th>
                                <th>الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseCategories as $courseCategory)
                                <tr>
                                    <td>{{ $courseCategory->id }}</td>
                                    <td>{{ $courseCategory->name }}</td>
                                    <td>{{ $courseCategory->is_active ? 'نعم' : 'لا' }}</td>
                                    <td>{{ $courseCategory->grade ? $courseCategory->grade->name : 'N/A' }}</td>
                                    <td>
                                        <!-- Edit Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $courseCategory->id }}">
                                            تعديل
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $courseCategory->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $courseCategory->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $courseCategory->id }}">تعديل بيانات الفئة</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('course_categories.update', $courseCategory->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="name{{ $courseCategory->id }}" class="form-label"> اسم الفئة </label>
                                                                <input type="text" class="form-control" id="name{{ $courseCategory->id }}" name="name" value="{{ $courseCategory->name }}" required>
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror   
                                                            </div>
                                                            <div class=" mb-3">
                                                                <input class="form-check-input" type="checkbox" id="is_active{{ $courseCategory->id }}" name="is_active" {{ $courseCategory->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="is_active{{ $courseCategory->id }}">
                                                                    مفعل ام لا
                                                                </label>
                                                                @error('is_active')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="grade_id{{ $courseCategory->id }}" class="form-label">الصف الدراسي</label>
                                                                <select class="form-select" id="grade_id{{ $courseCategory->id }}" name="grade_id">
                                                                    <option value="">اختر الصف الدراسي</option>
                                                                    @foreach ($grades as $grade)
                                                                        <option value="{{ $grade->id }}" {{ $courseCategory->grade_id == $grade->id ? 'selected' : '' }}>
                                                                            {{ $grade->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('grade_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror 
                                                            </div>
                                                            <button type="submit" class="btn btn-warning">تعديل</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('course_categories.destroy', $courseCategory->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('هل تود حذف الفئة الدراسية؟');
        }
    </script>

@endsection
