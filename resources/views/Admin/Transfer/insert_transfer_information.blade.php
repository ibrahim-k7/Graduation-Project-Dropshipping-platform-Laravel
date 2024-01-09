@extends('Admin.layouts.main')

@section('pageTitle')
    اضافة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>ادخال معلومات تحويل جديدة</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Validation</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-5">
                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="ابراهيم محمد عبدالله الخياط" required>
                                            <small id="name_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">رقم الهاتف</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                placeholder="777676006" required>
                                            <small id="phone_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-6">
                                            <label for="transfer_network" class="form-label">اسم شبكة التحويل</label>
                                            <input type="text" class="form-control" id="transfer_network" name="transfer_network"
                                                placeholder="النجم" required>
                                            <small id="transfer_network_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">إرسال</button>
                                            <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                                        </div>
                                    </form><!-- End Multi Columns Form -->
                        </div>



                    </div>
                </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // عند تحميل الصفحة

            var transferInformation = @json($transferInformation ?? null);

            if (transferInformation != null) {
                $("#name").val(transferInformation.name);
                $("#phone").val(transferInformation.phone);
                $("#transfer_network").val(transferInformation.transfer_network);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#phone_error').text('');
                    $('#transfer_network_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.transfer.info.update') }}",
                        data: {
                            'id' : transferInformation.transfer_info_id,
                            'name': $("input[name='name']").val(),
                            'phone': $("input[name='phone']").val(),
                            'transfer_network': $("input[name='transfer_network']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "لقد تم حفظ التحديث بنجاح",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            console.log('suc: ' + data);
                        },
                        error: function(reject) {
                            //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function(key, val) {
                                $("#" + key + "_error").text(val[0]);


                            });


                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "فشلت عملية التحديث",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            } else {
                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#phone_error').text('');
                    $('#transfer_network_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.transfer.info.store') }}",
                        data: {
                            'name': $("input[name='name']").val(),
                            'phone': $("input[name='phone']").val(),
                            'transfer_network': $("input[name='transfer_network']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "لقد تمت الإضافة بنجاح",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            console.log('suc: ' + data);
                        },
                        error: function(reject) {
                            // var error = data.responseJSON;
                            //console.log(error);

                            //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function(key, val) {
                                $("#" + key + "_error").text(val[0]);


                            });


                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "فشلت عملية الإضافة",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            }


        });
    </script>
@endsection
