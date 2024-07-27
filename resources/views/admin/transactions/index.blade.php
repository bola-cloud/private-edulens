<!-- resources/views/admin/transactions/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>جميع المعاملات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.index') }}" method="GET" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث" value="{{ request()->input('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">ابحث</button>
                </div>
            </form>

            @if($transactions->isEmpty())
                <p>لا توجد معاملات.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>رقم المعاملة</th>
                            <th>اسم المستخدم</th>
                            <th>الهاتف</th>
                            <th>المبلغ</th>
                            <th>الطريقة</th>
                            <th>الحالة</th>
                            <th>النوع</th>
                            <th>تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user ? $transaction->user->name . ' ' . $transaction->user->last_name : 'N/A' }}</td>
                                <td>{{ $transaction->user ? $transaction->user->phone : 'N/A' }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ \App\Http\Controllers\Admin\TransactionsController::translateMethod($transaction->method) }}</td>
                                <td>{{ \App\Http\Controllers\Admin\TransactionsController::translateStatus($transaction->status) }}</td>
                                <td>{{ \App\Http\Controllers\Admin\TransactionsController::translateType($transaction->type) }}</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
