@extends('Admin.layouts.main')

@section('pageTitle')
    تفاصيل الطلب المسترجعة
@endsection



@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>تفاصيل الطلب المسترجعة</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="Returned_Order_Managment_Details" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>معرف الطلب</th>
                                            <th>اسم المنتج</th>
                                            <th>الوصف</th>
                                            <th>الكمية المسترجعة</th>
                                            <th>اجمالي المنتج المسترجع</th>
                                            <th>تاريخ الاسترجاع</th>
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

            var returned_order_details_data = $('#Returned_Order_Managment_Details').DataTable({
                processing: true,
                serverSide: true,
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
                ajax: "{{ Route('admin.returned.order.details.data') }}",
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
                        columns: [0, 1, 2, 3, 4, 5, 6] // Column index which needs to export
                    }
                },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Column index which needs to export
                        }
                    },
                ],
                columns: [
                    {
                        data: 'return_id',
                        name: 'return_id'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
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
                        data: 'return_date',
                        name: 'return_date',
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
