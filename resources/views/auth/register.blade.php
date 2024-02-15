@extends('user.layouts.app')
@section('content')
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    {{-- <span class="d-none d-lg-block">انشاء حساب</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">انشاء حساب</h5>
                                        <p class="text-center small">ادخل معلوماتك الشخصيه لانشاء حساب</p>
                                    </div>

                                    <form method="POST" action="{{ route('register') }}"class="row g-3 needs-validation">
                                        @csrf
                                        <div class="col-12">
                                            <label for="store_name" class="form-label">الاسم</label>
                                            <input type="text" name="store_name" class="form-control" id="store_name"
                                                required>
                                            <div class="invalid-feedback">ادخل الاسم</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">الايميل</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                required>
                                            <div class="invalid-feedback">ادخل الايميل</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="phone_number" class="form-label">رقم الهاتف</label>
                                            <input type="tel" name="phone_number" class="form-control" id="phone_number"
                                                required>
                                            <div class="invalid-feedback">ادخل رقم الهاتف</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">كلمة السر</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            <div class="invalid-feedback">ادخل كلمة السر</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password_confirmation" class="form-label">تاكيد كلمة السر</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="password_confirmation" required>
                                            <div class="invalid-feedback">ادخل تاكيد كلمة السر</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">
                                                {{ __('ارسال') }}</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">لدي حساب <a href="{{ route('login') }}">
                                                    {{ __(' تسجيل الدخول') }}</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main><!-- End #main -->
@endsection
