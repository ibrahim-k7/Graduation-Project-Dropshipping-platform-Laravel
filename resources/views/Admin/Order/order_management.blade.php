@extends('Admin.layouts.main')

@section('pageTitle')
    الطلبات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>الطلبات</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="Order_Managment_User" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th> اسم المتجر</th>
                                            <th>التوصيل</th>
                                            <th>المنصة</th>
                                            <th>حالة الدفع</th>
                                            <th>اسم العميل</th>
                                            <th>هاتف العميل</th>
                                            <th>البريد الالكتروني للعميل</th>
                                            <th>عنوان الشحن</th>
                                            <th>حالة الطلب</th>
                                            <th>رسوم الشحن</th>
                                            <th>اجمالي الوزن</th>
                                            <th>اجمالي الطلب</th>
                                            <th>تاريخ الانشاء</th>
                                            <th>تاريخ التديث</th>
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

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script type="text/javascript">
        //دالة تحديث حالة الدفع
        function updatePaymentStatus(order_id, payment_status, total_amount = null, wallet_id = null) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.order.update.payment.status') }}",
                data: {
                    'order_id': order_id,
                    'payment_status': payment_status,
                    'total_amount': total_amount,
                    'wallet_id': wallet_id,
                },
                success: function(data) {
                    Swal.fire({
                        title: "تم التحديث",
                        text: "لقد تم تحديث حالة الدفع بنجاح",
                        icon: "success"
                    });

                    //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد التحديث
                    $('#Order_Managment_User').DataTable().ajax.reload();
                },
                error: function(reject) {
                    // يمكنك إضافة إجراءات إضافية هنا في حالة حدوث خطأ
                }
            });
        }
        $(document).on('click', '.payment-status-change-btn', function(e) {
            e.preventDefault();

            var order_id = $(this).attr('data-order-id');
            var payment_status = $(this).attr('data-payment_status');
            var total_amount = $(this).attr('data-total_amount');
            var wallet_id = $(this).attr('data-wallet_id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "تراجع",
                confirmButtonText: "نعم، قم بتغيير حالة الدفع"
            }).then((result) => {
                if (result.isConfirmed) {
                    updatePaymentStatus(order_id,payment_status,total_amount,wallet_id);
                }
            });
        });

        //تحديث حالة الطلب
        $(document).on('click', '.order-status-change-btn', function(e) {
            e.preventDefault();

            var order_id = $(this).attr('data-order-id');
            var order_status = $(this).attr('data-order_status');
            var payment_status = $(this).attr('data-payment_status');
            var total_amount = $(this).attr('data-total_amount');
            var wallet_id = $(this).attr('data-wallet_id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "تراجع",
                confirmButtonText: "نعم، قم بتغيير حالة الطلب"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.order.update.order.status') }}",
                        data: {
                            'id': order_id,
                            'order_status': order_status,
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم التحديث",
                                text: "لقد تم تحديث حالة الطلب بنجاح",
                                icon: "success"
                            });

                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد التحديث
                            $('#Order_Managment_User').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                            // يمكنك إضافة إجراءات إضافية هنا في حالة حدوث خطأ
                        }
                    });
                }
            });
        });

        $(function() {

            var order_data = $('#Order_Managment_User').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all',//كل الحقول
                    className: 'dt-right'//الاتجاه
                }],
                ajax: "{{ Route('admin.order.data') }}",
                dom: "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f><'col-sm-12 col-md-4'l>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json" // توفير ملف ترجمة للعربية
                },
                buttons: [{
                    extend: 'print',
                    autoPrint: false,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14] // Column index which needs to export
                    }
                },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14]  // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14]  // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14]  // Column index which needs to export
                        }
                    },

                ],
                columns: [{
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'store_name',
                        name: 'store_name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'platform',
                        name: 'platform'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        render: function(data, type, full, meta) {
                            // تحديد اللون بناءً على الحالة
                            var badgeClass = '';
                            if (data == 'تم الدفع') {
                                badgeClass = 'bg-success';
                            } else if (data == 'تم الغاء الدفع') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-warning';
                            }
                            // بناء العلامة بناءً على الحالة
                            var statusBadge = '<span class="badge ' + badgeClass + '">' + data +
                                '</span>';
                            return statusBadge;
                        }
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'customer_email',
                        name: 'customer_email'
                    },
                    {
                        data: 'shipping_address',
                        name: 'shipping_address'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status',
                        render: function(data, type, full, meta) {
                            // تحديد اللون بناءً على الحالة
                            var badgeClass = '';
                            if (data == 'تم التوصيل') {
                                badgeClass = 'bg-success';
                            } else if (data == 'تم الغاء الطلب') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-warning';
                            }
                            // بناء العلامة بناءً على الحالة
                            var statusBadge = '<span class="badge ' + badgeClass + '">' + data +
                                '</span>';
                            return statusBadge;
                        }
                    },
                    {
                        data: 'total_per_shp',
                        name: 'total_per_shp'
                    },
                    {
                        data: 'total_weight',
                        name: 'total_weight'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
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

        //حذف الطلب
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
                    var order_status = $(this).attr('data-order_status');
                    var order_id = $(this).attr('data-order-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.order.destroy') }}",
                        data: {
                            'id': order_id,
                            'order_status': order_status,
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف ",
                                text: "لقد تم حذف الطلب بنجاح",
                                icon: "success"
                            });

                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Order_Managment_User').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr
                                .responseText;

                            Swal.fire({
                                title: "فشلت عملية الحذف",
                                text: " لا يمكن حذف طلب تم توصيله ",
                                icon: "error"
                            });

                        }
                    });

                }
            });
        });

    </script>
@endsection
