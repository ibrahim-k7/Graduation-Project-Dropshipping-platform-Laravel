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
            <h1>Delivery</h1>
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
                                <table id="Delivery_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Shipping Fees</th>
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

            var delivery_data = $('#Delivery_Managment').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ Route('admin.delivery.data') }}",
                columns: [{
                        data: 'delivery_id',
                        name: 'delivery_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'shipping_fees',
                        name: 'shipping_fees'
                    },
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

                    var delivery_id = $(this).attr('delivery-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.delivery.delete') }}",
                        data: {
                            'id': delivery_id
                        },
                        success: function(data) {
                            Swal.fire({

                                title: "تم الحذف ",
                                text: "لقد تم حذف الملف الخاص بك",
                                icon: "success"
                            });

                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Delivery_Managment').DataTable().ajax.reload();
                        },
                        error: function(reject) {

                            Swal.fire({
                                title: "فشلت عملية الحذف",
                                icon: "error"
                            });
                        }
                    });

                }
            });

        });

    </script>
@endsection
