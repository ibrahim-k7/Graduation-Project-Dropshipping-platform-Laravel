@extends('Admin.layouts.main')

@section('pageTitle')
    عرض المشتريات
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>عرض المشتريات</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item">الجداول</li>
                    <li class="breadcrumb-item active">بيانات</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">جدول المشتريات</h5>
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="Purchase" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Supplier ID</th>
                                        <th>Payment Method</th>
                                        <th>Extra Expenses</th>
                                        <th>Total</th>
                                        <th>Amount Paid</th>
                                        <th>Created At</th>
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

            var purchase_data = $('#Purchase').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('admin.purchase.data') }}",
                columns: [{
                    data: 'purch_ID',
                    name: 'purch_ID'
                },
                    {
                        data: 'sup_ID',
                        name: 'sup_ID'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'Extra_expenses',
                        name: 'Extra_expenses'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'Amount_paid',
                        name: 'Amount_paid'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
