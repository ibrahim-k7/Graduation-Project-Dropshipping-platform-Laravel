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
                                                       placeholder="0"  readonly>
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
            var order_details = @json($order_details ?? null);
            var product = @json($product ?? null);
            var selling_price = parseInt(product.selling_price);
            var returned_product = @json($returned_product ?? null);

            //لحساب المبلغ المسترجع
            function updateAmountReturned() {
                var  quantityReturned = parseInt($('#quantity_returned').val()) || 0;
                var amountReturned = quantityReturned * selling_price;

                $('#amount_returned').val(amountReturned.toFixed(2));
            }

            if (returned_product != null) {
                $('#quantity_returned').val(returned_product.quantity_returned);
                $('#amount_returned').val(returned_product.amount_returned);
                $('#quantity_returned').on('input', updateAmountReturned);

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
                            'order_details_id' : returned_product.order_details_id,
                            'quantity_returned': $("input[name='quantity_returned']").val(),
                            'amount_returned': $("input[name='amount_returned']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تم تحديث المنتج المسترجع",
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

                                position: "top-end",
                                icon: "error",
                                title: "فشلت عملية التحديث المنتج المسترجع",
                                text: "لا يمكن استرجاع منتج كميته أو الاجمالي أقل",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            } else {
                $('#quantity_returned').on('input', updateAmountReturned);

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
                            'order_details_id' : order_details.order_details_id,
                            // 'quantity' : product.quantity,
                            // 'total_cost' : product.total_cost,
                            'quantity_returned': $("input[name='quantity_returned']").val(),
                            'amount_returned': $("input[name='amount_returned']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تم استرجاع المنتج",
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
                        }
                    });
                });
            }

        });
    </script>
@endsection
