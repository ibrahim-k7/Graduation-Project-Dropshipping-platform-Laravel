@extends('User.layouts.main')

@section('pageTitle')
    تفاصيل الطلبات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>تفاصيل الطلبات</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="container-fluid ">
                <div class="row pt-5 justify-content-center ">
                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات الطلب</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">رقم الطلب:
                                    <span class="p-3 text-dark" id="order_id">2</span>
                                </p>
                                <p class="text-dark fs-5">تاريخ الطلب:
                                    <span class="p-3 text-dark" id="order_date">2020-12-21 sep </span>
                                </p>
                                <p class="text-dark fs-5">طريقة التوصيل:
                                    <span class="p-3 text-dark" id="delivery_name"></span>
                                </p>
                                <p class="text-dark fs-6 fw-bold">حالة الطلب:
                                    <span class="p-3 text-warning" id="order_status">0</span>
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-auto">
                        <div class="card ">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات العميل</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">اسم العميل:
                                    <span class="p-3 text-dark" id="customer_name">محمد عبدالخالق</span>
                                </p>
                                <p class="text-dark fs-5">البريد الإلكتروني:
                                    <span class="p-3 text-dark" id="customer_email">mohammed@gmial.com</span>
                                </p>
                                <p class="text-dark fs-5">العنوان:
                                    <span class="p-3 text-dark fs-6" id="shipping_address">صنعاء التحرير</span>
                                </p>
                                <p class="text-dark fs-5">رقم الجوال:
                                    <span class="p-3 text-dark" id="customer_phone">776273760</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">حالة الدفع</div>
                            <div class="card-body py-3 text-center">
                                <p class="text-danger fw-bolder mb-4" id="payment_status">لم يتم الدفع</p>
                                <a href="#" class="btn btn-outline-success">أدفع</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row pt-5 justify-content-evenly ">

                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">المنتجات</div>
                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="products" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>معرف النتج</th>
                                            <th>الصورة</th>
                                            <th>اسم المنتج</th>
                                            <th>الكمية</th>
                                            <th>الوزن</th>
                                            <th>الوزن فرعي</th>
                                            <th>السعر</th>
                                            <th>المبلغ الفرعي</th>
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

                    <div class="col col-lg-auto">
                        <div class="card ">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">مجموع الطلب</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">المبلغ الجمالي:
                                    <span class="pe-3 text-dark" id="total_per_shp">0</span>
                                    ر.ي
                                </p>
                                <p class="text-dark fs-5">الوزن الإجمالي:
                                    <span class="pe-3 text-dark" id="total_weight">0.0</span>
                                    kg
                                </p>
                                <p class="text-dark fs-5">رسوم الشحن:
                                    <span class="pe-3 text-dark" id="shipping_fees">0</span>
                                    ر.ي
                                </p>
                                <p class="text-dark fs-5">المجموع الكلي:
                                    <span class="pe-3 text-dark" id="total_amount">0</span>
                                    ر.ي
                                </p>
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
                url: "{{ route('user.order.details.getOrderInfo') }}", // استبدل بعنوان النهاية الخاصة بك
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // قم بمعالجة البيانات هنا
                    console.log(data);
                    $('#order_id').text(data.order_id);
                    $('#order_date').text(data.created_at);
                    $('#order_status').text(data.order_status);
                    $('#delivery_name').text(data.name);
                    $('#customer_name').text(data.customer_name);
                    $('#payment_status').text(data.payment_status);
                    $('#customer_email').text(data.customer_email);
                    $('#shipping_address').text(data.shipping_address);
                    $('#customer_phone').text(data.customer_phone);
                    $('#total_per_shp').text(data.total_per_shp);
                    $('#total_weight').text(data.total_weight);
                    $('#shipping_fees').text(data.shipping_fees);
                    $('#total_amount').text(data.total_amount);




                },
                error: function(error) {
                    // إدارة الأخطاء هنا
                    console.error('حدث خطأ أثناء جلب البيانات', error);
                }
            });
            $(function() {

                var order_details_data = $('#products').DataTable({
                    processing: true,
                    serverSide: true,
                    //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                    columnDefs: [{
                        targets: '_all', //كل الحقول
                        className: 'dt-right' //الاتجاه
                    }],
                    ajax: "{{ Route('user.order.details.data') }}",
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
                                columns: [0, 1, 2, 3, 4,
                                    5
                                ] // Column index which needs to export
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4,
                                    5
                                ] // Column index which needs to export
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4,
                                    5
                                ] // Column index which needs to export
                            }
                        },
                        {
                            text: 'إضافة منتح',
                            className: 'custom-add-button',
                            action: function(e, dt, node, config) {
                                // تحويل المستخدم إلى الصفحة الجديدة عند النقر على زر "Add"
                                window.location.href =
                                    "{{ route('admin.suppliers.create') }}";
                            }
                        },
                    ],
                    columns: [{
                            data: 'order_details_id',
                            name: 'order_details_id'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'image',
                            name: 'image',
                            render: function(data, type, full, meta) {
                                return '<a href="../../Products_img/' + data +
                                    '" data-lightbox="product-image" data-title="Product Image">' +
                                    '<img src="../../Products_img/' + data +
                                    '" alt="Product Image" width="60" height="60">' +
                                    '</a>';
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },

                        {
                            data: 'weight',
                            name: 'weight'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                // حساب المبلغ الفرعي بضرب الكمية في التكلفة الإجمالية
                                return row.quantity * row.weight;
                            },
                            name: 'الوزن الفرعي'
                        },
                        {
                            data: 'selling_price',
                            render: function(data, type, row) {
                                // تنسيق سعر البيع بشكل "30.00 ر.س."
                                var formattedSellingPrice = row.selling_price.toFixed(2) +
                                    ' ر.ي.';
                                return formattedSellingPrice;
                            },
                            name: 'selling_price'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                // حساب المبلغ الفرعي بضرب الكمية في سعر البيع
                                var subTotal = row.quantity * row.selling_price;

                                // تنسيق الناتج بشكل مثل "30.00 ر.س."
                                var formattedSubTotal = subTotal.toFixed(2) + ' ر.ي.';

                                return formattedSubTotal;
                            },
                            name: 'المبلغ الفرعي'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });
            });

            //حذف منتج من تفاصيل المنتجات
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
                        var order_details_id = $(this).attr('data-order_details_id');
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                            },
                            url: "{{ route('user.order.details.destroy') }}",
                            data: {
                                'id': order_details_id,
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "تم الحذف ",
                                    text: "لقد تم حذف الطلب بنجاح",
                                    icon: "success"
                                });

                                //تحديث جدول البيانات لكي يظهر التعديل في الجدول بعد الحذف
                                $('#products').DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                // var errorMessage = xhr
                                //     .responseText;

                                // Swal.fire({
                                //     title: "فشلت عملية الحذف",
                                //     text: " لا يمكن حذف طلب تم توصيله ",
                                //     icon: "error"
                                // });

                            }
                        });

                    }
                });
            });
        });
    </script>
@endpush
