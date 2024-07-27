@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>تطبيق كوبون</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('coupons.applyCoupon') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="student_id" class="form-label">اختر الطالب</label>
                    <select id="student_id" name="user_id" class="form-control select2">
                        <option value="">ابحث عن الطالب بالاسم أو الهاتف</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->phone }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="coupon_code" class="form-label">كود الكوبون</label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" required>
                </div>

                <button type="submit" class="btn btn-success">تطبيق الكوبون</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'ابحث عن الطالب بالاسم أو الهاتف',
                allowClear: true
            });
        });
    </script>
@endpush
