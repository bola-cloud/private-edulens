<!-- resources/views/admin/charge/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>شحن المحفظة</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('charge.index') }}" method="GET">
                <div class="mb-3">
                    <label for="search" class="form-label">ابحث عن الطالب</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $search ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">ابحث</button>
            </form>

            @if(!empty($users))
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>رقم الهاتف</th>
                            <th>المحفظة</th>
                            <th>شحن/سحب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->wallet }}</td>
                                <td>
                                    <form action="{{ route('charge.charge') }}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="number" name="amount" class="form-control me-2" placeholder="المبلغ" required>
                                        <select name="type" class="form-control me-2" required>
                                            <option>اختر نوع المعاملة</option>
                                            <option value="deposite">شحن</option>
                                            <option value="withdraw">سحب</option>
                                        </select>
                                        <button type="submit" class="btn btn-success">تنفيذ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
