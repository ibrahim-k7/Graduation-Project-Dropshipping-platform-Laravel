@extends('user.layouts.main')

@section('pageTitle')
    قائمة منتجاتي
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>قائمة منتجاتي</h1>
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
                                            <th>الرصيد</th>
                                            <th>إسم المتجر</th>
                                            <th>معرف المتجر</th>
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

            var products_data = $('#Products_Managment').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                /*responsive: {
                    details: {
                        type: 'column'
                    }
                },*/
                /*responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                },*/
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('seller.products.data') }}",
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
                    { //اظاهر الحقول المراد عرضها
                        extend: 'colvis',
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
                        data: 'dealer_pro_id',
                        name: 'dealer_pro_id'
                    },
                    {
                        data: 'dealer_selling_price',
                        name: 'dealer_selling_price'
                    },
                    {
                        data: 'dealer_product_name',
                        name: 'dealer_product_name'
                    },
                    {
                        data: 'dealer_product_desc',
                        name: 'dealer_product_desc'
                    },
                    {
                        data: 'platform',
                        name: 'platform',
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
    </script>
    @endsection
