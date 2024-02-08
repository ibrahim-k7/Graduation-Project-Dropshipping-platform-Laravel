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
                                <button type="submit" id="submit" class="btn btn-primary" data-action="update">حفظ التحديث</button>
                                <button type="submit" id="submit_add" class="btn btn-primary" data-action="add">إضافة مشتريات جديدة</button>
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





        $(document).ready(function () {
            var purchaseData = @json($purchase ?? null);

            if (purchaseData != null) {
                $('#sup_id').val(purchaseData.sup_id);
                $('#payment_method').val(purchaseData.payment_method);
                $('#additional_costs').val(purchaseData.additional_costs);
                $('#total').val(purchaseData.total);
                $('#amount_paid').val(purchaseData.amount_paid);

                // قم بتعبئة تفاصيل المشتريات في الجدول
                // قم بتعبئة تفاصيل المشتريات في الجدول
                var purchaseDetails = @json($purchase->purchaseDetails ?? null);

                if (purchaseDetails != null && purchaseDetails.length > 0) {
                    for (var i = 0; i < purchaseDetails.length; i++) {
                        addProductRow(purchaseDetails[i].product.id, purchaseDetails[i].product.name, purchaseDetails[i].product.price, purchaseDetails[i].quantity, purchaseDetails[i].total_cost);


                        // قم بتعبئة الحقول في الصف المضاف بالبيانات
                        var currentRow = $("#purchaseDetailsBody tr").eq(i + 1); // انطلق من 1 لأن الصفوف تبدأ من 1
                        currentRow.find('td:eq(0)').text(i + 1); // رقم الصف
                        currentRow.find('td:eq(1)').text(purchaseDetails[i].product.id.name); // اسم المنتج
                        currentRow.find('td:eq(2)').text(purchaseDetails[i].product.price);
                        currentRow.find('td:eq(3)').text(purchaseDetails[i].quantity);
                        currentRow.find('td:eq(4)').text(purchaseDetails[i].total_cost);
                        currentRow.find('td:eq(5)').html('<button type="button" class="btn btn-danger" onclick="removeRow(this)">حذف</button>');
                        // قد تحتاج إلى تكرار هذا للحقول الأخرى حسب احتياجاتك
                        console.log('Purchase Details:', purchaseDetails[i]);
                    };
                }
            }

            var purchaseDetailsCounter = 1;

            // Function to add a new product row to the table
            function addProductRow(productID, productName, productPrice, quantity, totalCost) {
                var newRow = $("<tr>");
                var cells = [
                    $("<td>").text(purchaseDetailsCounter),
                    $("<td>").text(productID),
                    $("<td>").text(productPrice),
                    $("<td>").text(quantity),
                    $("<td>").text(totalCost),
                    $("<td>").html('<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>')
                ];

                newRow.append(cells);
                $("#purchaseDetailsBody").append(newRow);
                purchaseDetailsCounter++;
            }

            // Function to calculate and update the total of the purchase details
            function updateTotal() {
                var total = 0;

                $('#purchaseDetailsBody tr').each(function (index, row) {
                    total += parseFloat($(this).find('td:eq(4)').text());
                });

                $('#total').val(total.toFixed(2));
            }

            // Event handler for the "Add Product" button
            $(document).on('click', '#add_product', function () {
                var productid = $("select[name='pro_id']").val();
                var productName = $("select[name='pro_id'] option:selected").text();
                var productPrice = $("#product_price").val();
                var quantity = $("#quantity").val();
                var totalCost = (productPrice * quantity).toFixed(2);

                if (!productid || !productName || !productPrice || !quantity || !totalCost) {
                    alert('Please fill in all product details before adding.');
                    return;
                }

                // إضافة سطر للجدول
                addProductRow(productid, productName, productPrice, quantity, totalCost);
                // تحديث إجمالي الفاتورة
                updateTotal();
                // إعادة تعيين حقول الإدخال
                $("#pro_id, #product_price, #quantity, #total_cost").val('');
            });



        {{--    $(document).on('click', '#submit', function(e) {--}}
        {{--        e.preventDefault();--}}

        {{--        // اخفاء رسالة الخطأ عند الضغط على زر الإرسال مرة أخرى--}}
        {{--        $('#transaction_type_error').text('');--}}
        {{--        $('#amount_error').text('');--}}

        {{--        $.ajax({--}}
        {{--            type: 'post',--}}
        {{--            headers: {--}}
        {{--                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')--}}
        {{--            },--}}
        {{--            url: "{{ route('admin.purchase.update') }}", // تعديل هنا إلى الرابط الصحيح--}}
        {{--            data: {--}}
        {{--                'products': productsData,--}}
        {{--                'sup_id': $("select[name='sup_id']").val(),--}}
        {{--                'payment_method': $("select[name='payment_method']").val(),--}}
        {{--                'amount': $("input[name='amount']").val(),--}}
        {{--                'additional_costs': $("input[name='additional_costs']").val(),--}}
        {{--                'total': $("input[name='total']").val(),--}}
        {{--                'amount_paid': $("input[name='amount_paid']").val(),--}}
        {{--            },--}}
        {{--            success: function(data) {--}}
        {{--                $("#form")[0].reset();--}}
        {{--                Swal.fire({--}}
        {{--                    position: "top-end",--}}
        {{--                    icon: "success",--}}
        {{--                    title: "تم حفظ التحديث",--}}
        {{--                    showConfirmButton: false,--}}
        {{--                    timer: 2000--}}
        {{--                });--}}
        {{--                console.log('success: ' + data);--}}
        {{--            },--}}
        {{--            error: function(reject) {--}}
        {{--                // لوب لعرض الأخطاء في الحقول إذا كان هناك خطأ بسبب التحقق--}}
        {{--                var response = $.parseJSON(reject.responseText);--}}
        {{--                $.each(response.errors, function(key, val) {--}}
        {{--                    $("#" + key + "_error").text(val[0]);--}}
        {{--                });--}}

        {{--                Swal.fire({--}}
        {{--                    position: "top-end",--}}
        {{--                    icon: "error",--}}
        {{--                    title: "فشلت عملية التحديث",--}}
        {{--                    showConfirmButton: false,--}}
        {{--                    timer: 1500--}}
        {{--                });--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}

        });


        var purchaseDetailsCounter = 1;

        // داخل الحدث الخاص بزر "Add Product"
        $(document).on('click', '#add_product', function () {
            var productid = $("select[name='pro_id']").val();
            var productName = $("select[name='pro_id'] option:selected").text();
            var productPrice = $("#product_price").val();
            var quantity = $("#quantity").val();
            var totalCost = $("#total_cost").val();

            if (!productid || !productName || !productPrice || !quantity || !totalCost) {
                alert('Please fill in all product details before adding.');
                return;
            }

            // استخدام الدالة المحدثة
            addProductRow(productName, productid, productPrice, quantity, totalCost);

            // إعادة تعيين حقول الإدخال
            $("#pro_id, #product_price, #quantity, #total_cost").val('');
        });

        // داخل الدالة addProductRow
        function addProductRow(productName, productid, productPrice, quantity, totalCost) {
            // انشاء عنصر صف جديد
            var newRow = $("<tr>");

            // تعبئة الخلايا بالبيانات أو الحقول الفارغة حسب احتياجاتك
            var cells = [
                $("<td>").text(purchaseDetailsCounter),
                $("<td>").text(productid),
                $("<td>").text(productPrice),
                $("<td>").text(quantity),
                $("<td>").text(totalCost),
                $("<td>").html('<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>')
            ];

            // إضافة الخلايا إلى الصف
            newRow.append(cells);

            // إضافة الصف إلى الجدول
            $("#purchaseDetailsBody").append(newRow);

            // زيادة عداد التفاصيل
            purchaseDetailsCounter++;
        }

        // إرسال تفاصيل المشتريات مع التفاصيل
        $(document).on('click', '#submit', function(e) {
            e.preventDefault();

            var productsData = [];

            $('#purchaseDetailsBody tr').each(function(index, row) {
                // احصل على قيمة العناصر داخل كل صف
                var productID = $(this).find('td:eq(1)').text();
                //var productPrice = $(this).find('td:eq(2)').text();
                console.log('Product ID:', productID);
                var purchasing_price = $(this).find('td:eq(2)').text();
                var quantity = $(this).find('td:eq(3)').text();
                var totalCost = $(this).find('td:eq(4)').text();

                // أضف البيانات إلى مصفوفة المنتجات
                productsData.push({
                    pro_id: productID,
                    quantity: quantity,
                    purchasing_price: purchasing_price,
                    total_cost: totalCost
                });

                // يمكنك طباعة محتوى productsData للتحقق من البيانات التي تم جمعها
                //  console.log(productsData);


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

// Function to remove a row from the purchase details table
            function removeRow(btn) {
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }

// Reset fields when the reset button is clicked
            $(document).on('click', '#reset', function() {
                $("#form")[0].reset();
                $('#purchaseDetailsBody').empty();
                purchaseDetailsCounter = 1;
            });
        });


    </script>



@endsection
