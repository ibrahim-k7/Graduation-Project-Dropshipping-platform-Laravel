@extends('admin.layouts.app')

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

                            <div class="card mb-3" style="font-size: 20px !important;">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">انشاء حساب</h5>
                                        <p class="text-center small">ادخل معلوماتك الشخصيه لانشاء حساب</p>
                                    </div>

                                    <form method="POST" action="{{ route('admin.dshboard.store') }}"
                                        class="row g-3 needs-validation">
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">ادخل الاسم</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="admin_key" class="form-label">مفتاح الادمن</label>
                                            <input type="text" id="admin_key" class="form-control"
                                                @error('admin_key') is-invalid @enderror name="admin_key"
                                                value="{{ old('admin_key') }}" required autocomplete="admin_key" autofocus>
                                            @error('admin_key')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">ادخل مفتاح الادمن</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">الايميل</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="invalid-feedback">ادخل الايميل</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">كلمة السر</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                                {{ __('تسجيل الدخول') }}</button>
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
