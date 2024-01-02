@extends('Admin.layouts.main')

@section('pageTitle')
    عمليات المحافظ
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>عمليات المحافظ</h1>
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
                                <table id="Wallet_Operatioon" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th id="id_column">ID</th>
                                            <th>Amount</th>
                                            <th>Operation Type</th>
                                            <th>balance_aft_transfer</th>
                                            <th>Wallet ID</th>
                                            <th>Details</th>
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

            var supplier_data = $('#Wallet_Operatioon').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.wallets.operation.data') }}",
                dom: 'Bfrltip',
                buttons: [{
                        text: 'Add',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                             // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                    window.location.href = "{{ route('admin.wallets.operation.create') }}";
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
                    }, {
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6] // Column index which needs to export
                        }
                    }
                ],
                columns: [{
                        data: 'wallet_operation_id',
                        name: 'wallet_operation_id'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'operation_type',
                        name: 'operation_type'
                    },
                    {
                        data: 'balance_aft_transfer',
                        name: 'balance_aft_transfer'
                    },
                    {
                        data: 'wallet_id',
                        name: 'wallet_id'
                    },
                    {
                        data: 'details',
                        name: 'details'
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
                        data: 'action',
                        name: 'action'
                    },
                ]

            });

        });


    </script>
@endsection
