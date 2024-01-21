@extends('Admin.layouts.main')

@section('pageTitle')
    اضافة مشتريات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Insert New Purchase</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Validation</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card mt-5">
                                <div class="card-body">
                                    <h5 class="card-title">Purchase Form</h5>

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-6">
                                            <label class="mb-2" for="form-label">Supplier Info</label>
                                            <select class="form-select" aria-label="State" id="sup_id" name="sup_id">
                                                <option value="">اختر موردًا</option>
                                            </select>
                                            <small id="sup_id_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select class="form-select" id="payment_method" name="payment_method" required>
                                                <option value="نقد">نقد</option>
                                                <option value="اجل">آجل</option>
                                            </select>
                                            <small id="payment_method_error" class="form-text text-danger"></small>
                                        </div>

                                        <!-- Purchase Details Section -->
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="pro_id" class="form-label">رقم المنتج</label>
                                                <select class="form-select" id="pro_id" name="pro_id">
                                                    <option value="">اختر المنتج</option>

                                                </select>
                                                <small id="pro_id_error" class="form-text text-danger"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="product_price" class="form-label">سعر المنتج</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">ر.س</span>
                                                    <input type="number" class="form-control" id="product_price"
                                                        name="product_price" placeholder="سعر المنتج">
                                                </div>
                                                <small id="product_price_error" class="form-text text-danger"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="quantity" class="form-label">الكمية</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    placeholder="الكمية">
                                                <small id="quantity_error" class="form-text text-danger"></small>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="total_cost" class="form-label">التكلفة الإجمالية</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">ر.س</span>
                                                    <input type="number" class="form-control" id="total_cost"
                                                        name="total_cost" placeholder="التكلفة الإجمالية">
                                                </div>
                                                <small id="total_cost_error" class="form-text text-danger"></small>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="add_product" class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-success form-control"
                                                    id="add_product">إضافة المنتج</button>
                                            </div>
                                        </div>

                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="purchaseDetailsBody">
                                                <!-- Add dynamic rows for purchase details -->
                                            </tbody>
                                        </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="additional_costs" class="form-label">Additional Costs</label>
                                <input type="number" class="form-control" id="additional_costs" name="additional_costs"
                                    placeholder="Enter Additional Costs">
                                <small id="additional_costs_error" class="form-text text-danger"></small>
                            </div>
                            <div class="col-md-6">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" class="form-control" id="total" name="total"
                                    placeholder="Enter total">
                                <small id="total_error" class="form-text text-danger"></small>
                            </div>

                            <div class="col-md-6">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="number" class="form-control" id="amount_paid" name="amount_paid"
                                    placeholder="Enter Amount Paid">
                                <small id="amount_paid_error" class="form-text text-danger"></small>
                            </div>

                            <br>

                            <div class="text-center">
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script>
        // قم بتحميل بيانات الموردين باستخدام AJAX
        $.ajax({
            type: 'get',
            url: "{{ route('admin.supplier.getSuppliers') }}",
            async: false,
            success: function(data) {
                // قم بإضافة البيانات إلى عنصر الـselect
                $.each(data, function(key, supplier) {
                    $('#sup_id').append('<option value="' + supplier.sup_id + '">' +
                        '[ ID : ' + supplier.sup_id + ' ] Name : ' + supplier.name +
                        '</option>');

                });
            },
            error: function(reject) {
                console.error('Error loading suppliers:', reject);
            }
        });

        // قم بتحميل بيانات المنتجات باستخدام AJAX
        $.ajax({
            type: 'get',
            url: "{{ route('admin.product.getProducts') }}",
            async: false,
            success: function(data) {
                // قم بإضافة البيانات إلى عنصر الـselect
                $.each(data, function(key, product) {
                    $('#pro_id').append('<option value="' + product.id + '">' +
                        '[ ID : ' + product.id + ' ] Name : ' + product.name +
                        '</option>');
                    //  $('#product_price').val(product.purchasing_price);
                });
            },
            error: function(reject) {
                console.error('Error loading suppliers:', reject);
            }
        });

        var purchaseDetailsCounter = 1;

        $(document).ready(function() {
            // إضافة منتج جديد عند النقر على زر "Add Product"
            $(document).on('click', '#add_product', function() {
                var productName = $("select[name='pro_id']").val();
                var productPrice = $("#product_price").val();
                var quantity = $("#quantity").val();
                var totalCost = $("#total_cost").val();

                if (!productName || !productPrice || !quantity || !totalCost) {
                    alert('Please fill in all product details before adding.');
                    return;
                }

                var rowTemplate = `
                <tr>
                    <td>${purchaseDetailsCounter}</td>
                    <td>${productName}</td>
                    <td>${productPrice}</td>
                    <td>${quantity}</td>
                    <td>${totalCost}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
                    </td>
                </tr>`;

                purchaseDetailsCounter++;
                $('#purchaseDetailsBody').append(rowTemplate);

                // إعادة تعيين حقول الإدخال
                $("#pro_id, #product_price, #quantity, #total_cost").val('');
            });

            // إرسال تفاصيل المشتريات مع التفاصيل
            $(document).on('click', '#submit', function(e) {
                e.preventDefault();

                var productsData = [];

                $('#purchaseDetailsBody tr').each(function(index, row) {
                    // احصل على قيمة العناصر داخل كل صف
                    var productID = $(this).find('td:eq(1)').text();
                    //var productPrice = $(this).find('td:eq(2)').text();
                    console.log('Product ID:', productID);
                    var quantity = $(this).find('td:eq(3)').text();
                    var totalCost = $(this).find('td:eq(4)').text();

                    // أضف البيانات إلى مصفوفة المنتجات
                    productsData.push({
                        pro_id: productID,
                        quantity: quantity,
                        total_cost: totalCost
                    });
                });

                // يمكنك طباعة محتوى productsData للتحقق من البيانات التي تم جمعها
                //  console.log(productsData);


                // التحقق من توفر تفاصيل المشتريات
                if ($('#purchaseDetailsBody tr').length === 0) {
                    alert('Please add at least one product before submitting.');
                    return;
                }

                // احتساب إجمالي التكلفة لكل منتج وتخزينها في مصفوفة
                /* var purchaseDetails = [];
                 $('#purchaseDetailsBody tr').each(function() {
                     var rowData = [];
                     $(this).find('td').each(function() {
                         rowData.push($(this).text());
                     });
                     purchaseDetails.push(rowData);
                 });*/

                $('#sup_id_error').text('');
                $('#payment_method_error').text('');
                $('#additional_costs_error').text('');
                $('#total_error').text('');
                $('#amount_paid_error').text('');



                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('admin.purchase.store') }}",
                    data: {
                        'products': productsData,
                        'sup_id': $("select[name='sup_id']").val(),
                        'payment_method': $("select[name='payment_method']").val(),
                        'amount': $("input[name='amount']").val(),
                        'additional_costs': $("input[name='additional_costs']").val(),
                        'total': $("input[name='total']").val(),
                        'amount_paid': $("input[name='amount_paid']").val(),
                    },
                    success: function(data) {

                        $("#form")[0].reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "تمت العملية بنجاح",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        // console.log('suc: ' + data);
                    },
                    error: function(reject) {

                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0])
                        })
                    }
                });
            });

            // إزالة صف من جدول التفاصيل
            function removeRow(btn) {
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }

            // إعادة تعيين الحقول عند النقر على زر الريست
            $(document).on('click', '#reset', function() {
                $("#form")[0].reset();
                $('#purchaseDetailsBody').empty();
                purchaseDetailsCounter = 1;
            });

        });
    </script>
    t>
@endsection
