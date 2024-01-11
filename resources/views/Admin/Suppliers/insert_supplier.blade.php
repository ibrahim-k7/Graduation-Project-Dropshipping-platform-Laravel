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
<<<<<<< HEAD
            <h1>Insert New Supplier</h1>
=======
            <h1>إضافة مورد جديد</h1>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
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
<<<<<<< HEAD
                        <div class="card-body">
                            <div class="card mt-5">
                                <div class="card-body ">
                                    <h5 class="card-title">Supplier Form</h5>
=======
                        <div class="card-body mt-5">
>>>>>>> fad06c427242629c39afca398ff220bb11b23866

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-12">
<<<<<<< HEAD
                                            <label for="name" class="form-label">Supplier Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="ibrahim Mohammed" required>
                                            <small id="name_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Supplier Email</label>
=======
                                            <label for="name" class="form-label">اسم المورد</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="ابراهيم محمد الخياط" required>
                                            <small id="name_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">البريد الالكتروني</label>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="example@example.com" required>
                                            <small id="email_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
<<<<<<< HEAD
                                            <label for="phone" class="form-label">Supplier Phone Number</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                placeholder="777777777" required>
                                            <small id="phone_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Supplier Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="ibrahim Mohammed" required>
                                            <small id="address_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
=======
                                            <label for="phone" class="form-label">رقم الهاتف</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                placeholder="777676006" required>
                                            <small id="phone_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">عنوان المورد</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="صنعاء / شملان" required>
                                            <small id="address_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">إرسال</button>
                                            <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                                        </div>
                                    </form><!-- End Multi Columns Form -->


<<<<<<< HEAD
                                </div>
                            </div>
=======
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                        </div>



                    </div>
                </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script>
<<<<<<< HEAD
        $(document).on('click', '#submit', function(e) {
            e.preventDefault();

            //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
            $('#name_error').text('');
            $('#email_error').text('');
            $('#phone_error').text('');
            $('#address_error').text('');

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.suppliers.store') }}",
                data: {
                    'name': $("input[name='name']").val(),
                    'email': $("input[name='email']").val(),
                    'phone': $("input[name='phone']").val(),
                    'address': $("input[name='address']").val(),
                },
                success: function(data) {

                    $("#form")[0].reset();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "the new supplier has been saved",
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
=======
        $(document).ready(function() {
            // عند تحميل الصفحة

            var supplier = @json($supplier ?? null);

            if (supplier != null) {
                $("#name").val(supplier.name);
                $("#email").val(supplier.email);
                $("#phone").val(supplier.phone_number);
                $("#address").val(supplier.address);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#email_error').text('');
                    $('#phone_error').text('');
                    $('#address_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.suppliers.update') }}",
                        data: {
                            'id' : supplier.sup_id,
                            'name': $("input[name='name']").val(),
                            'email': $("input[name='email']").val(),
                            'phone_number': $("input[name='phone']").val(),
                            'address': $("input[name='address']").val(),
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

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#email_error').text('');
                    $('#phone_error').text('');
                    $('#address_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.suppliers.store') }}",
                        data: {
                            'name': $("input[name='name']").val(),
                            'email': $("input[name='email']").val(),
                            'phone_number': $("input[name='phone']").val(),
                            'address': $("input[name='address']").val(),
                        },
                        success: function(data) {

                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تمت الإضافة بنجاح",
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
                                title: "فشلت عملية الإضافة",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });
            }


>>>>>>> fad06c427242629c39afca398ff220bb11b23866
        });
    </script>
@endsection
