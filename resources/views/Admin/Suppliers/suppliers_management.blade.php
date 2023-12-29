@extends('Admin.layouts.main')

@section('pageTitle')
    المحفظة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Wallet</h1>
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
                                <table id="Supplier_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th id="id_column">ID</th>
                                            <th id="name_column">Name</th>
                                            <th id="email_column">Email</th>
                                            <th>Address</th>
                                            <th>Phone Number</th>
                                            <th>Balance</th>
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

            var supplier_data = $('#Supplier_Managment').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('admin.suppliers.data') }}",
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

                    var supplier_id = $(this).attr('data-supplier-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.supplier.destroy') }}",
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

                        }
                    });

                }
            });





        });






        /* $(document).ready(function(){
             $('#wallet_table_id').DataTable({
               

             });
         });*/
    </script>
@endsection
