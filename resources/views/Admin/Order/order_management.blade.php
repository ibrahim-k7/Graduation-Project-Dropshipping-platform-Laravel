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
                ajax: "{{ Route('admin.order.data') }}",
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
