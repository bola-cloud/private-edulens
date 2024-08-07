@extends('layouts.front')

@section('content')
<div class="container-fluid bg-white p-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar bg-light">
                <a href="#" data-target="student-data" class="text-dark"> بياناتي </a>
                <a href="#" data-target="wallet-recharge" class="text-dark">شحن المحفظة</a>
                <a href="#" data-target="balance-history" class="text-dark">سجل الرصيد</a>
                <a href="#" data-target="my-courses" class="text-dark">كورساتي</a>
                <a href="#" data-target="my-exams" class="text-dark">امتحاناتي</a>
                {{-- <a href="#" data-target="notifications" class="text-dark">الاشعارات</a> --}}
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Student-data Section -->
            <div id="student-data" class="content-section active">
                <div class="dashboard-header mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الرصيد</h5>
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->wallet }} ج.م</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الكورسات</h5>
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->courses()->count() }} كورس</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الامتحانات</h5>
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->exam()->count() }} امتحان</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User Information Form -->
                <div class="card bg-light" style="border-radius: 16px !important;">
                    <div class="card-body">
                        <h5 class="card-title mt-3 mb-5">بياناتي</h5>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('POST')
                            <div class="mb-3 row">
                                <label for="firstName" class="col-sm-2 col-form-label text-dark">الاسم الأول</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-dark bg-white" id="firstName" name="name" value="{{ old('name', Auth::user()->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="lastName" class="col-sm-2 col-form-label text-dark">الاسم الأخير</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-dark bg-white" id="lastName" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="phone" class="col-sm-2 col-form-label text-dark">رقم الهاتف</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-dark bg-white" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="parentPhone" class="col-sm-2 col-form-label text-dark">رقم هاتف ولي الأمر</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-dark bg-white" id="parentPhone" name="parent_phone" value="{{ old('parent_phone', Auth::user()->parent_phone) }}">
                                    @error('parent_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="gender" class="col-sm-2 col-form-label text-dark">الجنس</label>
                                <div class="col-sm-10">
                                    <select class="form-select text-dark bg-white" id="gender" name="gender">
                                        <option value="ذكر" {{ old('gender', Auth::user()->gender) == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                                        <option value="انثي" {{ old('gender', Auth::user()->gender) == 'انثي' ? 'selected' : '' }}>انثي</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="gradeId" class="col-sm-2 col-form-label text-dark">الصف</label>
                                <div class="col-sm-10">
                                    <select class="form-select text-dark bg-white" id="gradeId" name="grade_id">
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}" {{ old('grade_id', Auth::user()->grade_id) == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="governorateId" class="col-sm-2 col-form-label text-dark">المحافظة</label>
                                <div class="col-sm-10">
                                    <select class="form-select text-dark bg-white" id="governorateId" name="governorate_id">
                                        @foreach($governorates as $governorate)
                                            <option value="{{ $governorate->id }}" {{ old('governorate_id', Auth::user()->governorate_id) == $governorate->id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('governorate_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="type" class="col-sm-2 col-form-label text-dark">النوع</label>
                                <div class="col-sm-10">
                                    <select class="form-select text-dark bg-white" id="type" name="type">
                                        <option value="center" {{ old('type', Auth::user()->type) == 'center' ? 'selected' : '' }}>Center</option>
                                        <option value="online" {{ old('type', Auth::user()->type) == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-2 col-form-label text-dark">كلمة المرور</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control text-dark bg-white" id="password" name="password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-sm-2 col-form-label text-dark">تأكيد كلمة المرور</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control text-dark bg-white" id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Wallet Recharge Section -->
            <div id="wallet-recharge" class="content-section">
                <div class="dashboard-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الرصيد</h5>
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->wallet }} ج.م</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 bg-light" style="border-radius: 16px !important;">
                    <div class="card-body">
                        <h5 class="card-title">شحن المحفظة</h5>
                        <p>يمكنك شحن المحفظة عن طريق ارسال المبلغ موبايل كاش على الارقام التالية</p>
                        <!-- Contact Sections -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="contact-section bg-white text-dark p-3" style="border-radius: 16px;">
                                    <div class="contact-section-title d-flex align-items-center justify-content-between">
                                        ارقام واتساب
                                        <i class="fab fa-whatsapp contact-icon"></i>
                                    </div>
                                    <p>01220221292</p>
                                    <p>01220221292</p>
                                    <p>01220221292</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contact-section bg-white text-dark p-3" style="border-radius: 16px;">
                                    <div class="contact-section-title d-flex align-items-center justify-content-between">
                                        ارقام فودافون كاش
                                        <i class="fas fa-money-bill-wave contact-icon"></i>
                                    </div>
                                    <p>01220221292</p>
                                    <p>01220221292</p>
                                    <p>01220221292</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Balance History Section -->
            <div id="balance-history" class="content-section">
                <div class="dashboard-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الرصيد</h5>
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->wallet }} ج.م</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 bg-light p-4 border-16">
                            <table class="table bg-light table-shadow p-5">
                                <thead class="bg-white">
                                    <tr class="text-dark">
                                        <th scope="col">الخدمة</th>
                                        <th scope="col">المبلغ</th>
                                        <th scope="col">طريقة الدفع</th>
                                        {{-- <th scope="col">الرصيد السابق</th>
                                        <th scope="col">الرصيد الحالي</th> --}}
                                        <th scope="col">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $key => $transaction)
                                        <tr class="text-dark">
                                            @if ($transaction->type == "deposite")
                                                <td>ايداع</td>
                                            @else
                                                <td>سحب</td>
                                            @endif
                                            <td>{{ $transaction->amount }}</td>
                                            @if ($transaction->method == "wallet")
                                                <td>محفظة</td>
                                            @elseif($transaction->method == "code")
                                                <td>كود</td>
                                            @elseif($transaction->method == "paymob")
                                                <td>باي موب</td>
                                            @endif
                                            <td>{{ $transaction->created_at }}</td>
                                            {{-- <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->amount }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- My Courses Section -->
            <div id="my-courses" class="content-section">
                <div class="dashboard-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الكورسات</h5>
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->courses()->count() }} كورس</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5 p-5 bg-light border-16">
                        <div id="coursesCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @php
                                    $chunks = Auth::user()->courses->chunk(3);
                                @endphp
                                @foreach($chunks as $chunkIndex => $chunk)
                                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                        <div class="row">
                                            @foreach($chunk as $course)
                                                <div class="col-md-4">
                                                    <div class="card bg-white">
                                                        <img class="card-img-top img-size" src="{{ asset($course->image) }}" alt="Course image">
                                                        <div class="card-body">
                                                            <h2 class="card-title text-end text-dark"> {{$course->name}} </h2>
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                            <a href="{{ route('course_content', $course->id) }}" class="btn btn-gradient d-flex justify-content-between pe-5 pt-2 pb-2 w-100">
                                                                <span>مشاهدة الكورس</span>
                                                                <i class="fas fa-chevron-left mt-2 ms-3"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#coursesCarousel" data-bs-slide="prev">
                                <i class="fas fa-chevron-left"></i>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#coursesCarousel" data-bs-slide="next">
                                <i class="fas fa-chevron-right"></i>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <!-- My Exams Section -->
            <div id="my-exams" class="content-section">
                <div class="dashboard-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title text-dark">الامتحانات</h5>
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <p class="card-text">{{ Auth::user()->exam()->count() }} امتحان</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 bg-light p-4 border-16">
                            <table class="table bg-light table-shadow p-5">
                                <thead class="bg-white">
                                    <tr class="text-dark">
                                        <th scope="col">الامتحان</th>
                                        <th scope="col">الدرجة</th>
                                        <th scope="col"> النسبة</th>
                                        {{-- <th scope="col">الرصيد السابق</th>
                                        <th scope="col">الرصيد الحالي</th> --}}
                                        <th scope="col">الاجابات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->exam as $key => $exam)
                                        <tr class="text-dark">
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->pivot->student_degree }}/{{ $exam->degree }}</td>
                                            <td>{{ ($exam->pivot->student_degree/ $exam->degree) *100}} %</td>
                                            <td>
                                                <a href="{{route('exam_answers',$exam->id)}}" class="btn btn-beige pt-2 pb-2 ps-4 pe-4"> الاجابات </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notifications Section -->
            <div id="notifications" class="content-section">
                <div class="dashboard-header">
                    <h5 class="card-title">الاشعارات</h5>
                    <p>محتوى الاشعارات هنا...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');

            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            document.getElementById(target).classList.add('active');

            // Remove active class from all links
            document.querySelectorAll('.sidebar a').forEach(link => {
                link.classList.remove('active');
            });

            // Add active class to the clicked link
            this.classList.add('active');
        });
    });
</script>
@endpush
