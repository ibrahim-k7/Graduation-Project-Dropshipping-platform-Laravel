@extends('User.Layouts.main')

@section('pageTitle')
    إدارة المنتجات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>ربط ال API</h1>
            <nav>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold">ال API الخاص بك</div>
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table id="API_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Domain</th>
                                        <th>secret</th>
                                        <th>key</th>
                                        <th>created_at</th>
                                        <th>updated_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>


                </div>
                <div class="col-lg-12">

                    <div class="col col-lg-auto">
                        <div class="card ">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات ربط ال API</div>
                            <div class="card-body py-3 justify-content-end">
                                <form id="form" method="POST" class="row g-3">

                                    <div class="col-md-12 mt-4">
                                        <label>المجال الخاص بموقعك (Domain)</label>
                                        <input type="text" class="form-control " id="domain" name="domain"
                                            required="">
                                        <small id="domain_error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label>Secret</label>
                                        <input type="text" class="form-control " id="secret" name="secret"
                                            required="">
                                        <small id="secret_error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label>Key</label>
                                        <input type="text" class="form-control " id="key" name="key"
                                            required="">
                                        <small id="key_error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="submit" class="btn btn-primary">إرسال</button>
                                        <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                                    </div>
                                </form>
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
        $(document).ready(function() {
            $(function() {

                var API_table = $('#API_table').DataTable({
                    processing: true,
                    serverSide: true,
                    "autoWidth": false,
                    //إمكانية تحريك الاعمدة
                    colReorder: true,
                    order: [
                        [0, "desc"]
                    ],
                    //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                    columnDefs: [{
                        targets: '_all', //كل الحقول
                        className: 'dt-right' //الاتجاه
                    }],
                    ajax: "{{ Route('user.API.getDataTable') }}",
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json" // توفير ملف ترجمة للعربية
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'domain',
                            name: 'domain',
                        },
                        {
                            data: 'secret',
                            name: 'secret'
                        },
                        {
                            data: 'key',
                            name: 'key'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data, type, full, meta) {
                                // تنسيق التاريخ باستخدام moment.js
                                return moment(data).format('YYYY-MM-DD HH:mm:ss');
                            }
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            render: function(data, type, full, meta) {
                                // تنسيق التاريخ باستخدام moment.js
                                return moment(data).format('YYYY-MM-DD HH:mm:ss');
                            }
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });
            });

            $(document).on('click', '#submit', function(e) {
                e.preventDefault();

                // تعيين قيمة للمتغير بناءً على الزر الذي تم النقر عليه
                var actionType = $(this).data('action-type');

                // إذا كانت القيمة تدل على أنها إضافة
                if (actionType === 'add') {
                    // تنفيذ الطلب Ajax للإضافة
                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#domain_error').text('');
                    $('#secret_error').text('');
                    $('#key_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('user.API.store') }}",
                        data: {
                            'domain': $("input[name='domain']").val(),
                            'secret': $("input[name='secret']").val(),
                            'key': $("input[name='key']").val(),
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
                            $('#API_table').DataTable().ajax.reload();
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
                                title: reject.responseJSON.errors.store_id ? response
                                    .errors.store_id[0] : "فشلت عملية الإضافة",
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }
                    });
                } else if (actionType === 'update') {
                    // إذا كانت القيمة تدل على أنها تحديث
                    //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                    $('#domain_error').text('');
                    $('#secret_error').text('');
                    $('#key_error').text('');

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $(
                                    'meta[name=csrf-token]')
                                .attr('content')
                        },
                        url: "{{ route('user.API.update') }}",
                        data: {
                            'domain': $("input[name='domain']")
                                .val(),
                            'secret': $("input[name='secret']")
                                .val(),
                            'key': $("input[name='key']").val(),
                            'id': api_id
                        },
                        success: function(data) {
                            $("#form")[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "تم التحديث بنجاح",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#submit').data('action-type', 'add');
                            $('#API_table').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                            //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                            var response = $.parseJSON(
                                reject.responseText);
                            $.each(response.errors,
                                function(key, val) {
                                    $("#" + key +
                                            "_error")
                                        .text(val[0]);
                                });
                            if (reject.errors.store_id) {
                                // إذا كان هناك خطأ في store_id (السجل موجود بالفعل)
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: reject.errors.store_id,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                // في حالة خطأ عام (ليس بسبب وجود السجل)
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "فشلت عملية الإضافة",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });

            // يمكن تعيين قيمة `data-action-type` في الزر في الصفحة HTML
            $('#submit').data('action-type', 'add');


            // $(document).on('click', '.update_btn', function() {
            //     $('#submit').data('action-type', 'update');
            // });


            var api_id;
            $(document).on('click', '.update_btn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "هل انت متأكد ؟",
                    text: "لن تتمكن من التراجع عن هذا",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "تراجع",
                    confirmButtonText: "نعم، "
                }).then((result) => {
                    if (result.isConfirmed) {

                        api_id = $(this).attr('data-api-id');
                        $.ajax({
                            type: 'get',
                            url: "{{ route('user.API.getById') }}",
                            data: {
                                'id': api_id
                            },
                            success: function(data) {
                                $('#domain').val(data.domain);
                                $('#secret').val(data.secret);
                                $('#key').val(data.key);
                                // تحريك التمرير إلى النموذج
                                $('html, body').animate({
                                    scrollTop: $('#form').offset()
                                        .top
                                }, 'slow');
                                $('#submit').data('action-type', 'update');
                            },
                            error: function(reject) {
                                console.error(' فشل :', error);
                                // Swal.fire({
                                //     title: "فشلت عملية الحذف",
                                //     text: "لا يمكن حذف مورد لدية رصيد",
                                //     icon: "error"
                                // });
                            }
                        });

                    }
                });
            });

            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "هل انت متأكد ؟",
                    text: "لن تتمكن من التراجع عن هذا",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "تراجع",
                    confirmButtonText: "نعم، احذفه"
                }).then((result) => {
                    if (result.isConfirmed) {

                        var api_id_data = $(this).attr('data-api-id');
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                            },
                            url: "{{ route('user.API.destroy') }}",
                            data: {
                                'id': api_id_data
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "تم الحذف ",
                                    text: "لقد تمت عملية الحذف بنجاح",
                                    icon: "success"
                                });
                                //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                                $('#API_table').DataTable().ajax.reload();
                            },
                            error: function(reject) {

                                Swal.fire({
                                    title: "فشلت عملية الحذف",
                                    icon: "error"
                                });
                            }
                        });

                    }
                });
            });




        });
    </script>
@endsection
