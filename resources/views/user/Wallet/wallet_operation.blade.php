@extends('User.Layouts.main')

@section('pageTitle')
    عمليات المحفظة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>عمليات المحفظة</h1>
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
                            <h5 class="card-text  mb-4 mt-3 text-center ">رصيدك هو <span id="balance"></span> </h5>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="User_Wallet_Operatioon" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>المبلغ</th>
                                            <th>نوع العملية</th>
                                            <th>الرصيد بعد العملية</th>
                                            <th>معرف المحفظة</th>
                                            <th>التفاصيل</th>
                                            <th>تاريخ الإنشاء</th>
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
    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: "{{ route('user.wallet.getBalance') }}",
            async: false,
            success: function(data) {
                // استخدام قيمة $wallet الفعلية التي تم استرجاعها من الخادم
                var balanceValue = data.balance;

                // تحديث عنصر الصفحة بقيمة الرصيد الجديدة
                $("#balance").html(balanceValue + '<span style="font-size: small;"> رس </span>');
            },
            error: function(reject) {
                console.error('Error loading :', reject);
            }
        });


        
            $('#User_Wallet_Operatioon').DataTable({
                "autoWidth": false,
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('user.wallets.operation.data') }}",
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
                    {
                        text: 'إيداع للمحفظة',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                            // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                            window.location.href = "{{ route('user.transfers') }}";
                        }
                    },
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
                ]

            });

        



    });

</script>
@endpush

