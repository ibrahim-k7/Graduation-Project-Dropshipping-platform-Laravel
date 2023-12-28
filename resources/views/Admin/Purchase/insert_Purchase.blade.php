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
                                            <label for="purch_id" class="form-label">Purchase ID</label>
                                            <input type="number" class="form-control" id="purch_id" name="purch_id" placeholder="Enter Purchase ID" required>
                                            <small id="purch_id_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sup_ID" class="form-label">Supplier ID</label>
                                            <input type="number" class="form-control" id="sup_ID" name="sup_ID" placeholder="Enter Supplier ID" required>
                                            <small id="sup_ID_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select class="form-select" id="payment_method" name="payment_method" required>
                                                <option value="cash">نقد</option>
                                                <option value="credit">آجل</option>
                                            </select>
                                            <small id="payment_method_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="extra_expenses" class="form-label">Additional Costs</label>
                                            <input type="number" class="form-control" id="extra_expenses" name="extra_expenses" placeholder="Enter Additional Costs" required>
                                            <small id="extra_expenses_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="total" class="form-label">Total</label>
                                            <input type="number" class="form-control" id="total" name="total" placeholder="Enter Total" required>
                                            <small id="total_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="amount_paid" class="form-label">Amount Paid</label>
                                            <input type="number" class="form-control" id="amount_paid" name="amount_paid" placeholder="Enter Amount Paid" required>
                                            <small id="amount_paid_error" class="form-text text-danger"></small>
                                        </div>
                                        <!-- Purchase Invoice Details -->
                                        <div class="card shadow mb-4 mt-5">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary"> Purchase Invoice Details </h6>
                                            </div>

                                            <div class="card-body">
                                                <!-- Add your fields here based on the provided names -->
                                                <form id="purchaseDetailsForm" class="row g-3">
                                                    <div class="col-md-3">
                                                        <label for="product_name" class="form-label">Product Name</label>
                                                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="product_price" class="form-label">Product Price</label>
                                                        <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="quantity" class="form-label">Quantity</label>
                                                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="total_cost" class="form-label">Total Cost</label>
                                                        <input type="number" class="form-control" id="total_cost" name="total_cost" placeholder="Enter Total Cost" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="add_product" class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-success form-control" id="add_product">Add Product</button>
                                                    </div>
                                                </form>

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
        var purchaseDetailsCounter = 1;

        $(document).ready(function() {
            // إضافة منتج جديد عند النقر على زر "Add Product"
            $(document).on('click', '#add_product', function() {
                var productName = $("#product_name").val();
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
                $("#product_name, #product_price, #quantity, #total_cost").val('');
            });

            // إرسال تفاصيل المشتريات مع التفاصيل
            $(document).on('click', '#submit', function(e) {
                e.preventDefault();

                // اخفاء رسائل الخطأ عند الضغط على زر الإرسال مرة أخرى
                $('.form-text.text-danger').text('');

                // التحقق من توفر بيانات المشتريات
                var purchaseFields = ['sup_ID', 'payment_method', 'extra_expenses', 'total', 'amount_paid'];
                var isPurchaseDataValid = true;

                purchaseFields.forEach(function(field) {
                    if (!$(`#${field}`).val()) {
                        $(`#${field}_error`).text('This field is required.');
                        isPurchaseDataValid = false;
                    }
                });

                if (!isPurchaseDataValid) {
                    return;
                }

                // التحقق من توفر تفاصيل المشتريات
                if ($('#purchaseDetailsBody tr').length === 0) {
                    alert('Please add at least one product before submitting.');
                    return;
                }

                // احتساب إجمالي التكلفة لكل منتج وتخزينها في مصفوفة
                var purchaseDetails = [];
                $('#purchaseDetailsBody tr').each(function() {
                    var rowData = [];
                    $(this).find('td').each(function() {
                        rowData.push($(this).text());
                    });
                    purchaseDetails.push(rowData);
                });

                // إرسال بيانات الشراء وتفاصيله
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('admin.purchase.store') }}",
                    data: {
                        'payment_method': $("select[name='payment_method']").val(),
                        'sup_ID': $("input[name='sup_ID']").val(),
                        'extra_expenses': $("input[name='extra_expenses']").val(),
                        'total': $("input[name='total']").val(),
                        'amount_paid': $("input[name='amount_paid']").val(),
                        'purchase_details': purchaseDetails
                    },
                    success: function(data) {
                        $("#form")[0].reset();
                        $('#purchaseDetailsBody').empty(); // إفراغ جدول التفاصيل بعد إرسال البيانات بنجاح
                        purchaseDetailsCounter = 1; // إعادة تعيين عداد التفاصيل

                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "The new purchase has been saved",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        console.log('success: ' + data);
                    },
                    error: function(reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });

                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Failed to add purchase",
                            showConfirmButton: false,
                            timer: 1500
                        });
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
