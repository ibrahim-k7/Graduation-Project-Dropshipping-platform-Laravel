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
            <h1>Insert New Delivery</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Add Delivery</li>
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
                                    <h5 class="card-title">Delivery Form</h5>

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Delivery Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Mohammed Wadei" required>
                                            <small id="name_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="shipping_fees" class="form-label">Shipping Fees</label>
                                            <input type="text" class="form-control" id="shipping_fees" name="shipping_fees"
                                                placeholder="30" required>
                                            <small id="shipping_fees_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
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
            var delivery = @json($delivery ?? null);

            if (delivery != null) {
                $('#name').val(delivery.name);
                $('#shipping_fees').val(delivery.shipping_fees);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#shipping_fees_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.delivery.update') }}",
                        data: {
                            'id' : delivery.delivery_id,
                            'name': $("input[name='name']").val(),
                            'shipping_fees': $("input[name='shipping_fees']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "the Delivery has been updated",
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
                    $('#name_error').text('');
                    $('#shipping_fees_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.delivery.store') }}",
                        data: {
                            'name': $("input[name='name']").val(),
                            'shipping_fees': $("input[name='shipping_fees']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "the new Delivery has been updated",
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
                            $.each(response.errors, function(key,val){
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
