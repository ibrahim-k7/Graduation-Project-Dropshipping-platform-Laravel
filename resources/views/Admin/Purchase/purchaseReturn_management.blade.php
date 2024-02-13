@extends('Admin.layouts.main')

@section('pageTitle')
    عرض مرتجع الفواتير
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('admin.purchaseReturn_management.data') }}", // يجب استبدال هذا بالمسار الصحيح للبيانات المطلوبة
                dom: 'Bfrltip',
                buttons: [{
                        text: 'إضافة',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                            window.location.href = "{{ route('admin.purchase.purchase_management') }}"; // تحويل الى صفحة الإضافة
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف PDF
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف CSV
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف Excel
                        }
                    }, {
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى الطباعة
                        }
                    }
                ],
                columns: [{
                        data: 'return_id',
                        name: 'return_id'
                    },
                    {
                        data: 'purchase_details_id',
                        name: 'purchase_details_id'
                    },
                    {
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'quantity_returned',
                        name: 'quantity_returned'
                    },
                    {
                        data: 'amount_returned',
                        name: 'amount_returned'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
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
            var return_id = $(this).data('id'); // استخدمت $(this).data() بدلاً من $(this).attr()
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.purchaseReturn_management.destroy') }}", // يجب استبدال هذا بالمسار الصحيح للحذف
                data: {
                    'return_id': return_id
                },
                success: function(data) {
                    Swal.fire({
                        title: "تم الحذف ",
                        text: "تم حذف الملف بنجاح",
                        icon: "success"
                    });
                    $('#Return_Management').DataTable().ajax.reload(); // إعادة تحميل البيانات بعد الحذف
                },
                error: function(reject) {
                    // يمكنك إضافة معالجة للأخطاء هنا إذا لزم الأمر
                }
            });
        }
    });
});

    </script>
@endsection
