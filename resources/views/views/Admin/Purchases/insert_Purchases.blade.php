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
                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </form>

                                    <!-- Purchase Invoice Details -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"> Purchase Invoice Details </h6>
                                        </div>

                                        <div class="card-body">
                                            <!-- Add your fields here based on the provided names -->
                                            <table class="table table-bordered">
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
                                                <tbody>
                                                <!-- Add dynamic rows for purchase details -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
        $(document).on('click', '#submit', function(e) {
            e.preventDefault();

            // اخفاء رسائل الخطأ عند الضغط على زر الإرسال مرة أخرى
            $('#sup_ID_error').text('');
            $('#payment_method_error').text('');
            $('#extra_expenses_error').text('');
            $('#total_error').text('');
            $('#amount_paid_error').text('');

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.purchases.store') }}",
                data: {
                    'payment_method': $("select[name='payment_method']").val(),
                    'sup_ID': $("input[name='sup_ID']").val(),
                    'extra_expenses': $("input[name='extra_expenses']").val(),
                    'total': $("input[name='total']").val(),
                    'amount_paid': $("input[name='amount_paid']").val(),
                },
                success: function(data) {
                    $("#form")[0].reset();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "The new purchase has been saved",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.log('success: ' + data);

                    // يمكنك إضافة هنا الجزء الذي يقوم بتحديث تفاصيل الفاتورة بعد إضافة المشتريات
                    // يمكنك استخدام نفس الطريقة لجلب تفاصيل الفاتورة من الخادم وتحديث العرض
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
    </script>
@endsection
