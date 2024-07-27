@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <div class="row d-flex justify-content-center mt-3">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3> اضافة كورس جديد</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror 
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">المحتوى</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror 
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">الصورة</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                                @error('price')
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
                                <label for="type" class="form-label">نوع الاشتراك</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="center">Center</option>
                                    <option value="online">Online</option>
                                    <option value="all">All</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">الفئة</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value=""> اختر الفئة </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1">
                                <label class="form-check-label" for="is_active">مفعل ام لا</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"> اضافة </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
