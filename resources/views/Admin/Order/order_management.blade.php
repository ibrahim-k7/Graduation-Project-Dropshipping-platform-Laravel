@extends('Admin.layouts.main')

@section('pageTitle')
    الطلبات
@endsection



@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Order</h1>
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
                            <h5 class="card-title">Datatables</h5>
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="Order_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Store Name</th>
                                            <th>Delivery Name</th>
                                            <th>Platform</th>
                                            <th>Payment Status</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Customer Email</th>
                                            <th>Shipping Address</th>
                                            <th>Order Status</th>
                                            <th>Total Per Ship</th>
                                            <th>Total Weight</th>
                                            <th>Total Amount</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
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

            var order_data = $('#Order_Managment').DataTable({
                processing: true,
                serverSide: true,
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
                        name: 'payment_status'
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
                        name: 'order_status'
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
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
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
