@extends('User.Layouts.main')

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
                                <table id="User_Transfer_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>إسم المرسل</th>
                                            <th>هاتف المرسل</th>
                                            <th>رقم الحوالة</th>
                                            <th>المبلغ</th>
                                            <th>تاريخ التحويل</th>
                                            <th>الحالة</th>
                                            <th>صورة</th>
                                            <th>تاريخ الاإنشاء</th>
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

@push('js')
    
<script type="text/javascript">

    $(function() {

        if (!$.fn.DataTable.isDataTable('#User_Transfer_Managment')) {
        
        $('#User_Transfer_Managment').DataTable({
            processing: true,
            serverSide: true,
            "autoWidth": false,
            //إمكانية تحريك الاعمدة
            colReorder: true,
            responsive: true,
            order: [
                [0, "desc"]
            ],
            ajax: "{{ Route('user.transfers.getDataTableUser') }}",
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Column index which needs to export
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Column index which needs to export
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Column index which needs to export
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Column index which needs to export
                    }
                },
                {
                    text: 'إضافة حوالة',
                    className: 'custom-add-button',
                    action: function(e, dt, node, config) {
                         // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                window.location.href = "{{ route('user.transfers.create') }}";
                    }
                },
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
                    name: 'transfer_image',
                    render: function(data, type, full, meta) {
                        return '<a href="../../Transfers_img/' + data + '" data-lightbox="Transfer-image" data-title="Transfer Image">' +
                '<img src="../../Transfers_img/' + data + '" alt="Transfer Image" width="50" height="50">' +
                '</a>';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, full, meta) {
                        // تنسيق التاريخ باستخدام moment.js
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
            ]

        });
    }


    });

</script>
@endpush

