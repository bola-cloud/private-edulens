<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-radius bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">شراء الكورس</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('course_subscribe')}}" id="course_subscribe" method="POST">
                    @csrf
                    @method('post')
                    <!-- Payment Method -->
                    <div class="mb-3">
                        <label class="form-label d-flex">طريقة الدفع</label>
                        <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="wallet">المحفظة</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="wallet" value="wallet" checked>
                        </div>
                        {{-- <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="bayMob">باي موب</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="bayMob" value="bayMob">
                        </div> --}}
                        {{-- <div class="form-check custom-radio pay-method col-md-3 me-3">
                            <label class="form-check-label custom-radio-label" for="code">كود</label>
                            <input class="form-check-input" type="radio" name="paymentMethod" id="code" value="code">
                        </div> --}}
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                    </div>

                    <!-- Payment Code -->
                    <div class="mb-3" id="paymentCodeDiv" style="display: none;">
                        <label class="form-label">كود</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-white" placeholder="أدخل كود الدفع">
                            <button class="btn btn-confirm" type="button">تأكيد</button>
                        </div>
                    </div>

                    <!-- Discount Code -->
                    {{-- <div class="mb-3">
                        <label class="form-label">كود الخصم</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-white" placeholder="كود الخصم">
                            <button class="btn btn-apply" type="button">تطبيق</button>
                        </div>
                    </div> --}}

                    <!-- Pricing Details -->
                    <div class="mb-3">
                        <p> سعر الكورس: <span class="text-beige"> {{$course->price}} ج.م </span></p>
                        {{-- <p> الخصم: <span class="text-beige"> 0 ج.م </span></p> --}}
                        {{-- <p> الإجمالي: <span class="text-beige">  {{$course->price}} ج.م </span> </p> --}}
                        <p> رصيد المحفظة: <span class="text-beige">
                        @if(Auth::check())
                            {{Auth::user()->wallet}} ج.م </span> </p>
                        @endif 
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-gradient pt-2 pb-2 w-100" form="course_subscribe">تأكيد</button>
            </div>
        </div>
    </div>
</div>


<!-- Exam Modal -->
<div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-radius bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="examModalLabel">الامتحان</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-danger">تعليمات هامة</h6>
                <ul>
                    <li>الامتحان يفتح مرة واحدة فقط</li>
                    <li>عدد الاسئلة: <span id="exam-questions">30</span> سؤال</li>
                    <li>درجة النجاح: <span id="exam-degree">30</span> درجات</li>
                    <li>درجة الامتحان: <span id="exam-degree">30</span> درجة</li>
                    <li>مدة الامتحان: <span id="exam-time">30</span> دقيقة</li>
                </ul>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <a href="#" id="start-exam-button" class="btn btn-gradient pt-2 pb-2 col-md-8">ابدأ الامتحان</a>
            </div>
        </div>
    </div>
</div>