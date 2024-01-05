@extends('Admin.layouts.main')

@section('pageTitle')
    الحوالات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>الحوالات</h1>
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
                                <table id="Transfer_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Sender Name</th>
                                            <th>Sender Phone</th>
                                            <th>Transfer Number</th>
                                            <th>Amount</th>
                                            <th>Transfer Date</th>
                                            <th>Wallet ID</th>
                                            <th>status</th>
                                            <th>Image</th>
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
        //دالة تحديث حالة الحوالة
        function updateTransferStatus(transfer_id, status, transfer_number = null, amount_transferred = null, wallet_id =
            null) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.transfers.update') }}",
                data: {
                    'id': transfer_id,
                    'transfer_status': status,
                    'amount_transferred': amount_transferred,
                    'transfer_number': transfer_number,
                    'wallet_id': wallet_id,
                },
                success: function(data) {
                    Swal.fire({
                        title: "تم التحديث",
                        text: "لقد تم تحديث الحالة بنجاح",
                        icon: "success"
                    });

                    //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد التحديث
                    $('#Transfer_Managment').DataTable().ajax.reload();
                },
                error: function(reject) {
                    // يمكنك إضافة إجراءات إضافية هنا في حالة حدوث خطأ
                }
            });
        }

        $(document).on('click', '.status-change-btn', function(e) {
            e.preventDefault();

            var transfer_id = $(this).attr('data-transfer-id');
            var status = $(this).attr('data-status');
            var transfer_number = $(this).attr('data-transfer_number');
            var amount_transferred = $(this).attr('data-amount_transferred');
            var wallet_id = $(this).attr('data-wallet_id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "تراجع",
                confirmButtonText: "نعم، قم بتغيير الحالة"
            }).then((result) => {
                if (result.isConfirmed) {
                    updateTransferStatus(transfer_id, status, transfer_number, amount_transferred,
                        wallet_id);
                }
            });
        });

        $(function() {

            var transfer_data = $('#Transfer_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.transfers.data') }}",
                dom: 'Bfrltip',
                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Column index which needs to export
                        }
                    }, {
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Column index which needs to export
                        }
                    }
                ],
                columns: [{
                        data: 'transfer_id',
                        name: 'transfer_id'
                    },
                    {
                        data: 'sender_name',
                        name: 'sender_name'
                    },
                    {
                        data: 'sender_phone',
                        name: 'sender_phone'
                    },
                    {
                        data: 'transfer_number',
                        name: 'transfer_number'
                    },
                    {
                        data: 'amount_transferred',
                        name: 'amount_transferred'
                    },
                    {
                        data: 'transfer_date',
                        name: 'transfer_date'
                    },
                    {
                        data: 'wallet_id',
                        name: 'wallet_id'
                    },
                    {
                        data: 'transfer_status',
                        name: 'transfer_status',
                        render: function(data, type, full, meta) {
                            // تحديد اللون بناءً على الحالة
                            var badgeClass = '';
                            if (data == 'موافقة') {
                                badgeClass = 'bg-success';
                            } else if (data == 'مرفوضة') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-warning';
                            }
                            // بناء العلامة بناءً على الحالة
                            var statusBadge = '<span class="badge ' + badgeClass + '">' + data +
                                '</span>';
                            return statusBadge;
                        }
                    },
                    {
                        data: 'transfer_image',
                        name: 'transfer_image'
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
                        name: 'action',
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
                    var transfer_status = $(this).attr('data-transfer_status');
                    var transfer_id = $(this).attr('data-transfer-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.transfers.destroy') }}",
                        data: {
                            'id': transfer_id,
                            'status': transfer_status,
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف ",
                                text: "لقد تم حذف الملف الخاص بك",
                                icon: "success"
                            });

                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Transfer_Managment').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr
                            .responseText;
                            
                            Swal.fire({
                                title: "فشلت عملية الحذف",
                                text: "لا يمكن حذف حوالة تمت الموافقة عليها",
                                icon: "error"
                            });

                        }
                    });

                }
            });





        });
    </script>
@endsection
