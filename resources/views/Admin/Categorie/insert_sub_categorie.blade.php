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
            <h1>إضافة فئة فرعية جديدة</h1>
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
                                            <label class="mb-2" for="form-label">معلومات الفئة الرائيسية</label>
                                            <select class="form-select" aria-label="State" id="cat_id" name="cat_id">
                                                <option value="">اختر فئة</option>
                                            </select>
                                            <small id="cat_id_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="name" class="form-label">اسم الفئة الفرعية</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                            <small id="name_error" class="form-text text-danger"></small>
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
                url: "{{ route('admin.Categories.getCategories') }}",
                async: false,
                success: function(data) {
                    // قم بإضافة البيانات إلى عنصر الـselect
                    $.each(data, function(key, categories) {
                        $('#cat_id').append('<option value="' + categories.id + '">' +
                            '[ ID : ' + categories.id + ' ] Name : ' + categories.name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.error('Error loading categories:', reject);
                }
            });



            var subCategorie = @json($subCategorie ?? null);

            if (subCategorie != null) {

                // Disable the select element
                $('#cat_id').prop('disabled', true);
                // Find the option and make it selected
                $('#cat_id option[value="' + subCategorie.cat_id + '"]').prop('selected', true);
                // Optionally, make other options disabled to prevent selection changes
                $('#cat_id option').not(':selected').prop('disabled', true);
                $("#name").val(subCategorie.name);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();
                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.subCategories.update') }}",
                        data: {
                            'cat_id' : subCategorie.cat_id,
                            'id': subCategorie.id,
                            'name': $("input[name='name']").val(),

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

                    $('#cat_id_error').text('');
                    $('#name_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.subCategories.store') }}",
                        data: {
                            'cat_id': $("select[name='cat_id']").val(),
                            'name': $("input[name='name']").val(),
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
