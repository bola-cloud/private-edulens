<!-- resources/views/admin/coupons/index.blade.php -->

@extends('layouts.admin')

@section('content')
<style>
    svg.w-5.h-5 {
        width: 12px !important;
        height: 12px !important;
    }
    .flex.justify-between.flex-1.sm\:hidden {
        display: flex;
        margin: 8px;
    }
</style>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>الكوبونات الفعالة</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-4">
                <form action="{{ route('coupons.index') }}" method="GET" class="d-flex row">
                    <div class="me-2 col-3 mt-2">
                        <input type="text" name="search" class="form-control" placeholder="ابحث عن كوبون" value="{{ request()->input('search') }}">
                    </div>
                    <button type="submit" class="btn btn-primary col-1">ابحث</button>
                </form>
            </div>

            <p>إجمالي عدد الكوبونات: {{ $totalCoupons }}</p>
            <p>إجمالي عدد الكوبونات بعد التصفية: {{ $filteredCouponsCount }}</p>

            @if($coupons->isEmpty())
                <p>لا توجد كوبونات فعالة.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>الكود</th>
                            <th>القيمة</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>تاريخ الاستخدام</th>
                            <th>الفعالية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->value }}</td>
                                <td>{{ $coupon->start_at }}</td>
                                <td>{{ $coupon->end_at }}</td>
                                <td>{{ $coupon->use_date }}</td>
                                <td>{{ $coupon->is_active ? 'نعم' : 'لا' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="wrap-pagination-info mt-4">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
