@extends('admin.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div id="userInfo">
                        <p>الاسم: {{ Auth::guard('admin')->user()->name }}</p>
                        <p>الايميل: {{ Auth::guard('admin')->user()->email }}</p>
                        <button class="btn btn-primary" onclick="showUpdateForm('admin')">تحديث المعلومات</button>
                    </div>

                    <div id="updateEmailForm" style="display: none;">
                        <form method="POST" action="{{ route('profile.updateEmail') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">الايميل</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::guard('admin')->user()->email }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary"> تحديث الايميل</button>
                        </form>
                    </div>

                    <div id="updatePasswordForm" style="display: none;">
                        <form method="POST" action="{{ route('admin.profile.updatePassword') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة سر جديده </label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تاكيد كلمة السر الجديده  </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">تحديث كلمة السر </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showUpdateForm(section) {
        if (section === 'admin') {
            document.getElementById('userInfo').style.display = 'none';
            document.getElementById('updateEmailForm').style.display = 'block';
            document.getElementById('updatePasswordForm').style.display = 'block';
        }
    }
</script>

@endsection
