@extends('admin.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 50px">
                {{-- <div class="card-header">{{ __('Profile') }}</div> --}}

                <div class="card-body"  style="margin-top: 50px">
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Bootstrap Tabs -->
                    <ul class="nav nav-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="userInfo-tab" data-bs-toggle="tab" href="#userInfo">بيانات المستخدم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="updateEmailForm-tab" data-bs-toggle="tab" href="#updateEmailForm">تحديث الايميل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="updatePasswordForm-tab" data-bs-toggle="tab" href="#updatePasswordForm">تحديث كلمة السر</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="updatePhoneNumberForm-tab" data-bs-toggle="tab"
                                href="#updatePhoneNumberForm">تحديث رقم الهاتف</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="userInfo">
                            <p>الاسم: {{ Auth::guard('admin')->user()->name }}</p>
                            <p>الايميل: {{ Auth::guard('admin')->user()->email }}</p>
                            <p>الهاتف: {{ Auth::user()->phone_number }}</p>
                            {{-- <button class="btn btn-primary" onclick="showUpdateForm('admin')">تحديث المعلومات</button> --}}
                        </div>
                        <div class="tab-pane fade" id="updateEmailForm">
                            <form method="POST" action="{{ route('profile.updateEmail') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">الايميل</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::guard('admin')->user()->email }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث الايميل</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="updatePasswordForm">
                            <form method="POST" action="{{ route('profile.updatePassword') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="password" class="form-label">كلمة سر جديدة</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">تأكيد كلمة السر الجديدة</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث كلمة السر</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="updatePhoneNumberForm">
                            <form method="POST" action="{{ route('profile.updatePhoneNumber') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ Auth::guard('admin')->user()->phone_number }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث رقم الهاتف</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showUpdateForm(section) {
        // Activate the 'تحديث الايميل' tab when the button is clicked
        $('#myTabs a[href="#updateEmailForm"]').tab('show');
    }
</script>

@endsection
