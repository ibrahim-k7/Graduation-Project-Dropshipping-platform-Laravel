@extends('User.Layouts.main')

@section('pageTitle')
    إضافة حوالة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>إضافة حوالة </h1>
            <br>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">معلومات التحويل</h5>
                    <p class="card-text text-center">للإيداع للمحفظة يرجئ ارسل حوالة بالمبلغ المراد إيداعة للمحفظة للمعلومات
                        التالية </p>
                    <h6 class="card-subtitle mb-2 text-muted text-center">إسم المستلم / <span id="name"></span></h6>
                    <h6 class="card-subtitle mb-2 text-muted text-center">هاتف المستلم / <span id="phone"></span></h6>
                    <h6 class="card-subtitle mb-2 text-muted text-center">الشبكة / <span id="network"></span></h6>
                </div>
            </div>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-5">

                            <!-- Multi Columns Form -->
                            <form id="form" method="post" enctype="multipart/form-data" class="row g-3">
                                
                                <div class="col-md-4">
                                    <label for="sender_name" class="form-label">اسم المرسل</label>
                                    <input type="text" class="form-control" id="sender_name" name="sender_name" required>
                                    <small id="sender_name_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="sender_phone" class="form-label">هاتف المرسل</label>
                                    <input type="number" class="form-control" id="sender_phone" name="sender_phone"
                                        required>
                                    <small id="sender_phone_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="transfer_number" class="form-label">رقم الحوالة</label>
                                    <input type="number" class="form-control" id="transfer_number" name="transfer_number"
                                        required>
                                    <small id="transfer_number_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="amount_transferred" class="form-label">مبلغ الحوالة</label>
                                    <input type="number" class="form-control" id="amount_transferred"
                                        name="amount_transferred" required>
                                    <small id="amount_transferred_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="transfer_date" class="form-label">تاريخ التحويل</label>
                                    <input type="date" class="form-control" id="transfer_date" name="transfer_date"
                                        required>
                                    <small id="transfer_date_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="transfer_image" class="form-label">صورة سند الحوالة</label>
                                    <input type="file" class="form-control" id="transfer_image" name="transfer_image"
                                        required>
                                    <small id="transfer_image_error" class="form-text text-danger"></small>
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
        

        // عند تحميل الصفحة
        $(document).ready(function() {
            //عرض معلومات التحويل
        $.ajax({
            type: 'get',
            url: "{{ route('user.transfer.info.getTransferInfo') }}",
            async: false,
            success: function(data) {
                // تحديث قيم العناصر باستخدام البيانات المسترجعة
                $("#name").text(data.name);
                $("#phone").text(data.phone);
                $("#network").text(data.transfer_network);
            },
            error: function(reject) {
                console.error('Error loading :', reject);
            }
        });
            //عند الضغط على زر إرسال
            $(document).on('click', '#submit', function(e) {
                e.preventDefault();
                

                //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                $('#sender_name_error').text('');
                $('#sender_phone_error').text('');
                $('#transfer_number_error').text('');
                $('#amount_transferred_error').text('');
                $('#transfer_date_error').text('');
                $('#transfer_image_error').text('');

                var formData = new FormData($("#form")[0]);

                //حفظ المعلومات
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    url: "{{ route('user.transfers.store') }}",
                    data: formData,
                    success: function(data) {
                        $("#form")[0].reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "تمت الإضافة بنجاح",
                            showConfirmButton: false,
                            timer: 2000
                        });
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
        });
    </script>
@endsection
