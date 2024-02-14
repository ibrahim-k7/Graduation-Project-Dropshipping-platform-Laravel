@extends('user.layouts.main')

@section('pageTitle')
    قائمة منتجاتي
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>قائمة منتجاتي</h1>
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
                                <table id="Products_Managment" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>الصورة</th>
                                            <th>الإسم</th>
                                            <th>سعر البيع</th>
                                            <th>الباركود</th>
                                            <th>الفئة الرئيسية</th>
                                            <th>الفئة الفرعية</th>
                                            <th>الكمية المتوفره</th>
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

            var products_data = $('#Products_Managment').DataTable({
                processing: true,
                serverSide: true,
                "autoWidth": false,
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ Route('seller.products.data') }}",
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
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, ] // Column index which needs to export
                        }
                    },
                    { //اظاهر الحقول المراد عرضها
                        extend: 'colvis',
                    },

                ],
                columns: [
                    {
                        data: 'dealer_pro_id',
                        name: 'dealer_pro_id'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return '<a href="../../Products_img/' + data + '" data-lightbox="product-image" data-title="Product Image">' +
                    '<img src="../../Products_img/' + data + '" alt="Product Image" width="80" height="80">' +
                    '</a>';
                        }
                    },
                    {
                        data: 'dealer_product_name',
                        name: 'dealer_product_name'
                    },
                    {
                        data: 'dealer_selling_price',
                        name: 'dealer_selling_price'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'categorie',
                        name: 'categorie'
                    },
                    {
                        data: 'subCategorie',
                        name: 'subCategorie'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
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
                    var product_id = $(this).attr('data-product-id');
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('user.dealer.product.destroy') }}",
                        data: {
                            'id': product_id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف ",
                                text: "لقد تم الحذف ينجاح",
                                icon: "success"
                            });
                            //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                            $('#Products_Managment').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                        }
                    });
                }
            });
        });
        $(document).on('click', '.cart_btn', function(e) {
                e.preventDefault();
                var dealer_product_id = $(this).attr('data-product-id');

                console.log(dealer_product_id);
                //حفظ المعلومات
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    url: "{{ route('user.cart.store') }}",
                    data: {
                        'id':dealer_product_id,
                        },
                    success: function(data) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "تمت الإضافة بنجاح",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        console.log('suc: ' + data);
                    },
                    error: function(reject) {
                   
                    }
                });
            });
    </script>
    @endsection
