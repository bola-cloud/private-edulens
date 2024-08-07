@extends('layouts.admin')

@section('content')

    <div class="mt-3 container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>  ادارة الصفوف الدراسية </h5>
                        <a href="{{ route('grades.create') }}" class="btn btn-success"> اضافة صف جديد </a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم </th>
                                <th>مفعل</th>
                                <th>الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->id }}</td>
                                    <td>{{ $grade->name }}</td>
                                    <td>{{ $grade->is_active ? 'نعم' : 'لا' }}</td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $grade->id }}">
                                            تعديل
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $grade->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $grade->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $grade->id }}"> تعديل الصف </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="name{{ $grade->id }}" class="form-label"> اسم الصف الدراسي </label>
                                                                <input type="text" class="form-control" id="name{{ $grade->id }}" name="name" value="{{ $grade->name }}" required>
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <input class="form-check-input" type="checkbox" id="is_active{{ $grade->id }}" name="is_active" {{ $grade->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="is_active{{ $grade->id }}">
                                                                    مفعل ام لا
                                                                </label>
                                                                @error('is_active')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <button type="submit" class="btn btn-warning"> تعديل </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete button --}}
                                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
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
            return confirm('هل تود حذف الصف؟');
        }
    </script>

@endsection
