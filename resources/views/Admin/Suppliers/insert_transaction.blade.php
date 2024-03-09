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
            <h1>إضافة عملية جديدة لمورد</h1>
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
                                            <label class="mb-2" for="form-label">معلومات المورد</label>
                                            <select class="form-select" aria-label="State" id="sup_id" name="sup_id">
                                                <option value="">اختر موردًا</option>
                                            </select>
                                            <small id="sup_id_error" class="form-text text-danger"></small>
                                        </div>




                                        <div class="col-md-6">
                                            <label class="mb-2" for="form-label">نوع العملية</label>
                                            <select class="form-select" aria-label="State" id="transaction_type"
                                                name="transaction_type">
                                                <option value="">اختر نوع العملية</option>
                                                <option value="1">سداد</option>
                                                <option value="2">سحب</option>
                                            </select>
                                            <small id="transaction_type_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">المبلغ</label>
                                            <input type="number"   min="1"  class="form-control" id="amount" name="amount"
                                                required>
                                            <small id="amount_error" class="form-text text-danger"></small>
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
                url: "{{ route('admin.suppliers.getSuppliers') }}",
                async: false,
                success: function(data) {
                    // قم بإضافة البيانات إلى عنصر الـselect
                    $.each(data, function(key, supplier) {
                        $('#sup_id').append('<option value="' + supplier.sup_id + '">' +
                            '[ ID : ' + supplier.sup_id + ' ] Name : ' + supplier.name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.error('Error loading suppliers:', reject);
                }
            });



            var supplierTransaction = @json($supplierTransaction ?? null);

            if (supplierTransaction != null) {

                if (supplierTransaction.transaction_type == "سداد") {
                supplierTransaction.transaction_type = 1
            } else {
                supplierTransaction.transaction_type = 2
            }


                // Disable the select element
                $('#sup_id').prop('disabled', true);
                // Find the option and make it selected
                $('#sup_id option[value="' + supplierTransaction.sup_id + '"]').prop('selected', true);
                // Optionally, make other options disabled to prevent selection changes
                $('#sup_id option').not(':selected').prop('disabled', true);
                $('#transaction_type').prop('disabled', true);
                $('#transaction_type option[value="' + supplierTransaction.transaction_type + '"]').prop('selected',
                    true);
                $('#transaction_type option').not(':selected').prop('disabled', true);
                $("#amount").val(supplierTransaction.amount);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#transaction_type_error').text('');
                    $('#amount_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.suppliers.transactions.update') }}",
                        data: {
                            'sup_id' : supplierTransaction.sup_id,
                            'id': supplierTransaction.transaction_id,
                            'transaction_type': $("select[name='transaction_type']").val(),
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

                    $('#sup_id_error').text('');
                    $('#transaction_type_error').text('');
                    $('#amount_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.suppliers.transactions.store') }}",
                        data: {
                            'sup_id': $("select[name='sup_id']").val(),
                            'transaction_type': $("select[name='transaction_type']").val(),
                            'amount': $("input[name='amount']").val(),
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
