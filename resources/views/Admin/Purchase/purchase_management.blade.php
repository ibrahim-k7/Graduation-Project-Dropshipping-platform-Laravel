@extends('Admin.layouts.main')

@section('pageTitle')
    المشتريات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>المشتريات</h1>
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
                                <table id="Purchase_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Supplier ID</th>
                                            <th>Supplier Name</th>
                                            <th>Payment Method</th>
                                            <th>Additional Costs</th>
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

            var purchase_data = $('#Purchase_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.purchase.data') }}",
                dom: 'Bfrltip',
                buttons: [{
                        text: 'Add',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                             // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                    window.location.href = "{{ route('admin.purchase.create') }}";
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
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'sup_id',
                        name: 'sup_id'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'additional_costs',
                        name: 'additional_costs'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'amount_paid',
                        name: 'amount_paid'
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

                    var purch_id = $(this).attr('purch-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.purchase.destroy') }}",
                        data: {
                            'id': purch_id
                        },
                        success: function(data) {
                            Swal.fire({

                                title: "تم الحذف ",
                                text: "لقد تم حذف الملف الخاص بك",
                                icon: "success"
                            });
                        //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Purchase_Managment').DataTable().ajax.reload();
                        },
                        error: function(reject) {

                        }
                    });
                }
            });
        });
    </script>
@endsection
