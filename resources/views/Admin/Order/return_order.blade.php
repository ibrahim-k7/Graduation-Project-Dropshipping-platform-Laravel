@extends('Admin.layouts.main')

@section('pageTitle')
    استرجاع منتج
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>استرجاع منتج</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">استرجاع منتج</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card mt-5">
                                <div class="card-body ">

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-2">
                                            <label for="quantity_returned" class="form-label">الكمية المسترجعة</label>
                                            <input type="text" class="form-control" id="quantity_returned" name="quantity_returned"
                                                placeholder="10" required>
                                            <small id="quantity_returned_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="amount_returned" class="form-label">المبلغ المسترجع</label>
                                            <input type="text" class="form-control" id="amount_returned" name="amount_returned"
                                                placeholder="30" required>
                                            <small id="amount_returned_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">ارسال</button>
                                            <button type="reset" class="btn btn-secondary">اعادة تعيين</button>
                                        </div>
                                    </form><!-- End Multi Columns Form -->


                                </div>
                            </div>
                        </div>

                    </div>

                    </div>
                </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script>
        // عند تحميل الصفحة
        $(document).ready(function (){
            var product = @json($product ?? null);
            var returned_product = @json($returned_product ?? null);

            if (returned_product != null) {
                $('#quantity_returned').val(returned_product.quantity_returned);
                $('#amount_returned').val(returned_product.amount_returned);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#quantity_returned_error').text('');
                    $('#amount_returned_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.returned.order.details.update') }}",
                        data: {
                            'return_id' : returned_product.return_id,
                            'quantity_returned': $("input[name='quantity_returned']").val(),
                            'amount_returned': $("input[name='amount_returned']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تم تحديث النتج المسترجع",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            console.log('suc: ' + data);
                        },
                        error: function(reject) {

                            //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function(key,val){
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
                    $('#quantity_returned_error').text('');
                    $('#amount_returned_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.returned.order.details.store') }}",
                        data: {
                            'order_details_id' : product.order_details_id,
                            'quantity' : product.quantity,
                            'total_cost' : product.total_cost,
                            'quantity_returned': $("input[name='quantity_returned']").val(),
                            'amount_returned': $("input[name='amount_returned']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            console.log('suc: ' + data);
                        },
                        error: function(reject, xhr, status, error) {

                            //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function(key,val){
                                $("#" + key + "_error").text(val[0]);


                            });

                            var errorMessage = xhr
                                .responseText;

                            Swal.fire({
                                title: "فشلت عملية ارجاع المنتج",
                                text: "لا يمكن استرجاع منتج كميته أو الاجمالي أقل",
                                icon: "error"
                            });
                            // Swal.fire({
                            //     position: "top-end",
                            //     icon: "error",
                            //     title: "فشلت عملية الإضافة",
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // });
                        }
                    });
                });
            }

        });
    </script>
@endsection
