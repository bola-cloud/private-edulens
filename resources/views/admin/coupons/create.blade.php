<!-- resources/views/admin/coupons/create.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>إنشاء كوبونات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('coupons.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="number_of_coupons" class="form-label">عدد الكوبونات</label>
                    <input type="number" class="form-control @error('number_of_coupons') is-invalid @enderror" id="number_of_coupons" name="number_of_coupons" required>
                    @error('number_of_coupons')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">القيمة</label>
                    <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value" required>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">إنشاء الكوبونات</button>
            </form>
        </div>
    </div>
</div>
@endsection
