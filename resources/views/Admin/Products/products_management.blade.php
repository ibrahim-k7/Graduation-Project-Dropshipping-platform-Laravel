@extends('Admin.layouts.main')

@section('pageTitle')
    المنتجات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>المنتجات</h1>
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
                                <table id="Products_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>الأسم</th>
                                            <th>الفئة الرئيسية</th>
                                            <th>الفئة الفرعية</th>
                                            <th>الوصف</th>
                                            <th>سعر الشراء</th>
                                            <th>سعر البيع</th>
                                            <th>سعر البيع المقترح</th>
                                            <th>الوزن</th>
                                            <th>الكمية</th>
                                            <th>الباركود</th>
                                            <th>الصوره</th>
                                            <th>تاريخ الإنشاء</th>
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
        $(function() {

            var wallet_data = $('#Products_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.products.data') }}",
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all', //كل الحقول
                    className: 'dt-right' //الاتجاه
                }],
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
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        text: 'اضافة',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                            // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                            window.location.href = "{{ route('admin.products.create') }}";
                        }
                    },

                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'categorie',
                        name: 'categorie'
                    },
                    {
                        data: 'subCategorie',
                        name: 'subCategorie'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'purchasing_price',
                        name: 'purchasing_price'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },
                    {
                        data: 'suggested_selling_price',
                        name: 'suggested_selling_price'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            // تنسيق التاريخ باستخدام moment.js
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }z
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
                    var product_id = $(this).attr('data-product-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.products.destroy') }}",
                        data: {
                            'id': product_id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف ",
                                text: "لقد تم الحذف ينجاح",
                                icon: "success"
                            });
                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Categories_Managment').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                            Swal.fire({
                                title: "فشلت عملية الحذف",
                                text: "لا يمكن حذف منتج لدية كمية",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
