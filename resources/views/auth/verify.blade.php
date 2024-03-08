@extends('user.layouts.app')

@section('Content')
<main class="py-5">
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('تأكيد عنوان بريدك الإلكتروني') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('تم إرسال رابط التحقق إلى بريدك الإلكتروني بنجاح.') }}
                        </div>
                    @endif

                    {{ __('قبل المتابعة، يرجى التحقق من بريدك الإلكتروني للحصول على رابط التحقق.') }}
                    {{ __('إذا لم تستلم البريد الإلكتروني') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('انقر هنا لطلب رابط آخر') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
