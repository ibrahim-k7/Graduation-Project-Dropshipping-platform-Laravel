@extends('Admin.layouts.main')

@section('pageTitle')
    استعادة المشتريات
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>استعادة المشتريات</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item">الجداول</li>
                    <li class="breadcrumb-item active">بيانات</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">استعادة المشتريات</h5>
                            <p></p>

                            <div class="table-responsive">
                                <!-- Purchase Form -->
                                <form id="returnForm" method="post">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="purchase_details_id" class="form-label">Purchase Details ID</label>
                                        <input type="number" class="form-control" id="purchase_details_id" name="purchase_details_id" placeholder="Enter Purchase Details ID" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="return_date" class="form-label">Return Date</label>
                                        <input type="date" class="form-control" id="return_date" name="return_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quantity_returned" class="form-label">Quantity Returned</label>
                                        <input type="number" class="form-control" id="quantity_returned" name="quantity_returned" placeholder="Enter Quantity Returned" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="amount_returned" class="form-label">Amount Returned</label>
                                        <input type="number" class="form-control" id="amount_returned" name="amount_returned" placeholder="Enter Amount Returned" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="returnSubmit" class="btn btn-primary">Return</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                                <!-- End Purchase Form -->
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
        $(document).on('click', '#returnSubmit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.purchase.return') }}",
                data: {
                    'purchase_details_id': $("input[name='purchase_details_id']").val(),
                    'return_date': $("input[name='return_date']").val(),
                    'quantity_returned': $("input[name='quantity_returned']").val(),
                    'amount_returned': $("input[name='amount_returned']").val(),
                },
                success: function(data) {
                    $("#returnForm")[0].reset();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "تمت عملية الاسترجاع بنجاح",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.log('success: ' + data);
                },
                error: function(reject) {
                    var response = $.parseJSON(reject.responseText);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "فشلت عملية الاسترجاع",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    </script>
@endsection
