@extends('Admin.layouts.main')

@section('pageTitle')
<<<<<<< HEAD
    المحفظة
@endsection


=======
    الموردين
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
>>>>>>> fad06c427242629c39afca398ff220bb11b23866

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
<<<<<<< HEAD
            <h1>Wallet</h1>
=======
            <h1>الموردين</h1>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
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
<<<<<<< HEAD
                            <h5 class="card-title">Datatables</h5>
=======
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                            <p></p>

                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
<<<<<<< HEAD
                                <table id="Supplier_Managment"  class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Phone Number</th>
                                            <th>Created At</th>
=======
                                <table id="Supplier_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>الاسم</th>
                                            <th>البريد الالكتروني</th>
                                            <th>العنوان</th>
                                            <th>رقم الهاتف</th>
                                            <th>الرصيد</th>
                                            <th>تاريخ الانشاء</th>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
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

            var supplier_data = $('#Supplier_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
<<<<<<< HEAD
                ajax: "{{ Route('admin.suppliers.data') }}",
=======
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all',//كل الحقول
                    className: 'dt-right'//الاتجاه
                }],
                ajax: "{{ Route('admin.suppliers.data') }}",
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
                        text: 'اضافة',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                            // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                            window.location.href = "{{ route('admin.suppliers.create') }}";
                        }
                    },
                ],
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                columns: [{
                        data: 'sup_id',
                        name: 'sup_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
<<<<<<< HEAD
                        data: 'created_at',
                        name: 'created_at'
=======
                        data: 'balance',
                        name: 'balance'
                    },
                    /*{
                        data: 'trens',
                        name: 'SuplierTransactions.balance'
                    },*/
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            // تنسيق التاريخ باستخدام moment.js
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }

>>>>>>> fad06c427242629c39afca398ff220bb11b23866
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
<<<<<<< HEAD
            });
        });


=======

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

                    var supplier_id = $(this).attr('data-supplier-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.suppliers.destroy') }}",
                        data: {
                            'id': supplier_id
                        },
                        success: function(data) {
                            Swal.fire({

                                title: "تم الحذف ",
                                text: "لقد تم حذف الملف الخاص بك",
                                icon: "success"
                            });

                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Supplier_Managment').DataTable().ajax.reload();
                        },
                        error: function(reject) {

                            Swal.fire({
                                title: "فشلت عملية الحذف",
                                text: "لا يمكن حذف مورد لدية رصيد",
                                icon: "error"
                            });
                        }
                    });

                }
            });





        });






>>>>>>> fad06c427242629c39afca398ff220bb11b23866
        /* $(document).ready(function(){
             $('#wallet_table_id').DataTable({
               

             });
         });*/
    </script>
@endsection
