@extends('Admin.layouts.main')

@section('pageTitle')
    تفاصيل الطلبات
@endsection



@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Order Details</h1>
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
                                <table id="Order_Managment_Details" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Total Cost</th>
                                            <th>Sub Weight</th>
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

            var order_details_data = $('#Order_Managment_Details').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ Route('admin.order.details.data') }}",
                columns: [
                    {
                        data: 'order_details_id',
                        name: 'order_details_id'
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
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost'
                    },
                    {
                        data: 'sub_weight',
                        name: 'sub_weight'
                    },

                ]
            });
        });


    </script>
@endsection
