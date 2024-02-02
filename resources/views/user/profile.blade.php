@extends('user.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Profile') }}</div> --}}

                <div class="card-body">
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
                            <a class="nav-link" id="updatePasswordForm-tab" data-bs-toggle="tab" href="#updatePasswordForm">تحديث كلمة السر </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="userInfo">
                            <p>الاسم: {{ Auth::user()->store_name }}</p>
                            <p>الايميل: {{ Auth::user()->email }}</p>
                            <p>الهاتف: {{ Auth::user()->phone_number }}</p>
                            {{-- <button class="btn btn-primary" onclick="showUpdateForm('user')">Update Information</button> --}}
                        </div>
                        <div class="tab-pane fade" id="updateEmailForm">
                            <form method="POST" action="{{ route('user.profile.updateEmail') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">الايميل</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث الايميل</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="updatePasswordForm">
                            <form method="POST" action="{{ route('user.profile.updatePassword') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="password" class="form-label">كلمة سر جديدة</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">تاكيد كلمة السر الجديدة</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث كلمة السر</button>
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
        // Activate the 'Update Email' tab when the button is clicked
        $('#myTabs a[href="#updateEmailForm"]').tab('show');
    }
</script>

@endsection
