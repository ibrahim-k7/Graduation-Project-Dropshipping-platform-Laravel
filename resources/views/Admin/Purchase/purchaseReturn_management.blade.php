@extends('Admin.layouts.main')

@section('pageTitle')
    عرض مرتجع الفواتير
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* تصميم الهواتف المحمولة */
        @media (max-width: 767px) {
            #main.mobile-design {
                /* إضافة أنماط CSS للهواتف المحمولة هنا */
            }
        }

        /* تصميم الأجهزة اللوحية والحواسيب الشخصية */
        @media (min-width: 768px) {
            #main.desktop-design {
                /* إضافة أنماط CSS للأجهزة اللوحية والحواسيب الشخصية هنا */
            }
        }
    </style>

@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>عرض مرتجع الفواتير</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item">الجداول</li>
                    <li class="breadcrumb-item active">البيانات</li>
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
                                <!-- جدول بصفوف مخططة -->
                                <table id="Return_Management" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th>رقم الفاتورة</th>
                                        <th>تاريخ الارجاع</th>
                                        <th>الكمية المرتجعة</th>
                                        <th>المبلغ المرتجع</th>
                                        <th>تاريخ الانشاء</th>
                                        <th>العملية</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- نهاية الجدول بصفوف مخططة -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- نهاية #main -->
@endsection

@section('js')
    <script type="text/javascript">
        $(function() {


            var return_data = $('#Return_Management').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all',//كل الحقول
                    className: 'dt-right'//الاتجاه
                }],
                ajax: "{{ route('admin.purchaseReturn_management.data') }}", // يجب استبدال هذا بالمسار الصحيح للبيانات المطلوبة
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
                        columns: [0, 1, 2, 3, 4, 5, 6,7,8]// Column index which needs to export
                    }
                },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,7,8]// Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,7,8] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,7,8] // Column index which needs to export
                        }
                    },
                    {
                        text: 'اضافة',
                        className: 'custom-add-button',
                        action: function (e, dt, node, config) {
                            // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "إضافة"
                            window.location.href = "{{ route('admin.purchase.purchase_management') }}"; // تحويل الى صفحة الإضافة
                        }
                    },
                ],

                columns: [
                    {
                        // الرقم التعريفي
                        data: 'return_id',
                        name: 'return_id'
                    },
                    {
                        // رقم الفاتورة
                        data: 'purchase_details_id',
                        name: 'purchase_details_id'
                    },
                    {
                        // تاريخ الارجاع
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        // الكمية المرتجعة
                        data: 'quantity_returned',
                        name: 'quantity_returned'
                    },
                    {
                        // المبلغ المرتجع
                        data: 'amount_returned',
                        name: 'amount_returned'
                    },
                    {
                        // تاريخ الإنشاء
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }
                    },
                    {
                        // العملية
                        data: 'action',
                        name: 'action'
                    },
                ]

            });

        });

        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();

            var return_id = $(this).data('id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "تراجع",
                confirmButtonText: "نعم، احذفه"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.purchaseReturn_management.destroy') }}",
                        data: {
                            'return_id': return_id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف",
                                text: "تم حذف الملف بنجاح",
                                icon: "success"
                            });
                            $('#Return_Management').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                            var errorMessage = reject.responseJSON && reject.responseJSON.message ? reject.responseJSON.message : 'حدث خطأ أثناء معالجة الاسترجاع.';
                            Swal.fire({
                                title: "خطأ",
                                text: errorMessage,
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        // التحقق من حجم الشاشة وتحديد التصميم المناسب
        function checkScreenSize() {
            var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (screenWidth < 768) {
                // تحديد تصميم للهواتف المحمولة
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('mobile-design');
            } else {
                // تحديد تصميم للأجهزة اللوحية والحواسيب الشخصية
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('desktop-design');
            }
        }

        // تحقق من حجم الشاشة عند تحميل الصفحة
        window.onload = function() {
            checkScreenSize();
        };

        // تحقق من حجم الشاشة عند تغيير حجم النافذة
        window.onresize = function() {
            checkScreenSize();
        }

    </script>
@endsection
