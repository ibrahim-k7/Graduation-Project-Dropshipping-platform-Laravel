@extends('Admin.layouts.main')

@section('pageTitle')
    إضافة منتج
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>إضافة منتج</h1>
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
                            <form id="form" method="post" enctype="multipart/form-data" class="row g-3">

                                <div class="col-md-4">
                                    <label for="name" class="form-label">اسم المنتج</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="شاحن 12 فولت" required>
                                    <small id="name_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="selling_price" class="form-label">سعر البيع</label>
                                    <input type="number" class="form-control" id="selling_price" name="selling_price"
                                        placeholder="">
                                    <small id="selling_price_error" class="form-text text-danger"></small>
                                </div>

                                <div class="col-md-4">
                                    <label for="suggested_selling_price" class="form-label">سعر البيع المقترح</label>
                                    <input type="number" class="form-control" id="suggested_selling_price"
                                        name="suggested_selling_price" placeholder="">
                                    <small id="suggested_selling_price_error" class="form-text text-danger"></small>
                                </div>

                                <div class="col-md-6">
                                    <label class="mb-2" for="form-label">الفئة الرئيسية</label>
                                    <select class="form-select" aria-label="State" id="cat_id" name="cat_id">
                                        <option value="">اختر فئة رئيسية</option>
                                    </select>
                                    <small id="cat_id_error" class="form-text text-danger"></small>
                                </div>

                                <div class="col-md-6">
                                    <label class="mb-2" for="form-label">الفئة الفرعية</label>
                                    <select class="form-select" aria-label="State" id="subCat_id" name="subCat_id">
                                        <option value="">اختر فئة فرعية</option>
                                    </select>
                                    <small id="subCat_id_error" class="form-text text-danger"></small>
                                </div>

                                <div class="col-md-4">
                                    <label for="weight" class="form-label">الوزن</label>
                                    <input type="number" class="form-control" id="weight" name="weight" placeholder="">
                                    <small id="weight_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-4">
                                    <label for="barcode" class="form-label">الباركود</label>
                                    <input type="number" class="form-control" id="barcode" name="barcode" placeholder="">
                                    <small id="barcode_error" class="form-text text-danger"></small>
                                    
                                </div>

                                <div class="col-md-4">
                                    <label for="image" class="form-label">الصورة</label>
                                    <input type="file" class="form-control" id="image" name="image" placeholder="">
                                    <small id="image_error" class="form-text text-danger"></small>
                                </div>

                                <div class="input-group ">
                                    <span for="description" class="input-group-text">الوصف</span>
                                    <textarea class=" form-control" name="description" id="description" aria-label="With textarea"></textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" id="submit" class="btn btn-primary">إرسال</button>
                                    <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                                </div>
                            </form>


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

            // قم بتحميل بيانات الفئات  باستخدام AJAX
            $.ajax({
                type: 'get',
                url: "{{ route('admin.Categories.getCategories') }}",
                async: false,
                success: function(data) {
                    // قم بإضافة البيانات إلى عنصر الـselect
                    $.each(data, function(key, categories) {
                        $('#cat_id').append('<option value="' + categories.id + '">' +
                            categories.name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.error('Error loading categories:', reject);
                }
            });

            function loadSubCategories(selectedCategoryId) {
                // قم بتحميل الفئات الفرعية باستخدام AJAX
                $.ajax({
                    type: 'get',
                    url: "{{ route('admin.Categories.getSubCategories') }}",
                    data: {
                        categoryId: selectedCategoryId
                    },
                    success: function(data) {
                        // إزالة الخيارات القديمة في حقل الفئات الفرعية
                        $('#subCat_id').empty();

                        // إضافة الخيار الافتراضي
                        $('#subCat_id').append('<option value="">اختر فئة فرعية</option>');

                        // إضافة البيانات إلى عنصر الـselect للفئات الفرعية
                        $.each(data, function(key, subCategory) {
                            $('#subCat_id').append('<option value="' + subCategory.id + '">' +
                                subCategory.name +
                                '</option>');
                        });

                        if (product != null) {
                            $('#subCat_id').val(product.subCat_id);
                        }
                    },
                    error: function(reject) {
                        console.error('Error loading sub-categories:', reject);
                    }
                });
            };

            // استخدام الدالة عند تغيير الفئة الرئيسية
            $('#cat_id').on('change', function() {
                var selectedCategoryId = $(this).val();

                // فحص إذا كانت القيمة محددة
                if (selectedCategoryId) {
                    // استخدام الدالة لتحميل الفئات الفرعية
                    loadSubCategories(selectedCategoryId);
                }
            });




            var product = @json($product ?? null);

            if (product != null) {


                $("#name").val(product.name);
                $("#selling_price").val(product.selling_price);
                $("#suggested_selling_price").val(product.suggested_selling_price);
                $('#cat_id option[value="' + product.cat_id + '"]').prop('selected', true);

                loadSubCategories(product.cat_id);
                $("#weight").val(product.weight);
                $("#barcode").val(product.barcode);
                //$("#image").val(product.image);
                $("textarea").val(product.description);

                $(document).on('click', '#submit', function(e) {
                    e.preventDefault();

                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#name_error').text('');
                    $('#weight_error').text('');
                    $('#cat_id_error').text('');
                    $('#subCat_id_error').text('');
                    $('#image_error').text('');
                    $('#barcode_error').text('');

                    /* var formData = new FormData($("#form")[0]);
                     */

                    /* var image_update
                     if( $("#image").val(product.image) == null){
                         image_update = product.image;
                     }else{
                         image_update = $("#image")[0].files[0];
                     }*/

                    var formData = new FormData($("#form")[0]);
                    formData.append('id', product.id);
                    formData.append('oldImgName', product.image);
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        //enctype:'multipart/form-data',
                        url: "{{ route('admin.products.update') }}",
                        data: formData,
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

                    $('#name_error').text('');
                    $('#weight_error').text('');
                    $('#cat_id_error').text('');
                    $('#subCat_id_error').text('');
                    $('#image_error').text('');
                    $('#barcode_error').text('');


                    var formData = new FormData($("#form")[0]);
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        processData: false,
                        contentType: false,

                        url: "{{ route('admin.products.store') }}",
                        data: formData,
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
