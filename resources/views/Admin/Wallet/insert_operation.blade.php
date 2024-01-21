@extends('Admin.layouts.main')

@section('pageTitle')
    اضافة عملية للمحفظه
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>ادخال عملية جديده لمحفظة</h1>
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

                                        <div class="col-md-8">
                                            <label class="mb-2" for="form-label">معلومات المحفظة</label>
                                            <select class="form-select" aria-label="State" id="wallet_id" name="wallet_id">
                                                <option value="">اختر محفظة</option>
                                            </select>
                                            <small id="wallet_id_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="mb-2" for="form-label">نوع العملية</label>
                                            <select class="form-select" aria-label="State" id="operation_type"
                                                name="operation_type">
                                                <option >اختر نوع العملية</option>
                                                <option value="1">ايداع</option>
                                                <option value="2">سحب</option>
                                            </select>
                                            <small id="operation_type_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">المبلغ</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                required>
                                            <small id="amount_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-12">
                                            <label for="details" class="form-label">تفاصيل</label>
                                            <input type="text" class="form-control" id="details" name="details"
                                                required>
                                            <small id="details_error" class="form-text text-danger"></small>
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

            // قم بتحميل بيانات الموردين باستخدام AJAX
            $.ajax({
                type: 'get',
                url: "{{ route('admin.wallets.getWallets') }}",
                async: false,
                success: function(data) {
                    // قم بإضافة البيانات إلى عنصر الـselect
                    $.each(data, function(key, wallet) {
                        $('#wallet_id').append('<option value="' + wallet.wallet_id + '">' +
                            '[ ID : ' + wallet.wallet_id + ' ] Store Name : ' + wallet.store
                            .store_name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.error('Error loading Wallets:', reject);
                }
            });

            var walletOperation = @json($walletOperation ?? null);

            if (walletOperation != null) {

                if (walletOperation.operation_type == "ايداع") {
                walletOperation.operation_type = 1
            } else {
                walletOperation.operation_type = 2
            }

                // Disable the select element
                $('#wallet_id').prop('disabled', true);
                // Find the option and make it selected
                $('#wallet_id option[value="' + walletOperation.wallet_id + '"]').prop('selected', true);
                // Optionally, make other options disabled to prevent selection changes
                $('#wallet_id option').not(':selected').prop('disabled', true);
                $('#operation_type').prop('disabled', true);
                $('#operation_type option[value="' + walletOperation.operation_type + '"]').prop('selected',
                    true);
                $('#operation_type option').not(':selected').prop('disabled', true);
                $("#amount").val(walletOperation.amount);
                $("#details").val(walletOperation.details);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();
                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#details_error').text('');
                    $('#amount_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.wallets.operation.update') }}",
                        data: {
                            'wallet_id': walletOperation.wallet_id,
                            'id': walletOperation.wallet_operation_id,
                            'operation_type': $("select[name='operation_type']").val(),
                            'details': $("input[name='details']").val(),
                            'amount': $("input[name='amount']").val(),
                            

                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تمت عملية التحديث بنجاح",
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

                    $('#wallet_id_error').text('');
                    $('#operation_type_error').text('');
                    $('#amount_error').text('');
                    $('#details_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.wallets.operation.store') }}",
                        data: {
                            'wallet_id': $("select[name='wallet_id']").val(),
                            'operation_type': $("select[name='operation_type']").val(),
                            'amount': $("input[name='amount']").val(),
                            'details': $("input[name='details']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تمت العملية بنجاح",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            // console.log('suc: ' + data);
                        },
                        error: function(reject) {

                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function(key, val) {
                                $("#" + key + "_error").text(val[0])
                            })
                        }
                    });
                });
            }

        });
    </script>
@endsection
