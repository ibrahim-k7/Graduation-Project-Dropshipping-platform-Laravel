@extends('user.layouts.app')

@section('Content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="assets/img/logo.png" alt="">
                        {{-- <span class="d-none d-lg-block">انشاء حساب</span> --}}
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3" style="font-size: 20px !important;">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">انشاء حساب</h5>
                            <p class="text-center small">ادخل معلوماتك الشخصيه لانشاء حساب</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation">
                            @csrf
                            <div class="col-12">
                                <label for="store_name" class="form-label">الاسم</label>
                                <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" id="store_name" required>
                                @error('store_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">الايميل</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="phone_number" class="form-label">رقم الهاتف</label>
                                <input type="tel" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label">كلمة السر</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="password_confirmation" class="form-label">تاكيد كلمة السر</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
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

            </div>
        </div>
    </div>
@endsection
