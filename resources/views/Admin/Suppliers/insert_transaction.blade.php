@extends('Admin.layouts.main')

@section('pageTitle')
    اضافة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Insert New Supplier Transaction</h1>
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
                                <div class="card-body ">
                                    <h5 class="card-title">Supplier Transaction Form</h5>

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf

                                        <div class="col-md-8">
                                            <label class="mb-2" for="form-label">Supplier Info</label>
                                            <select class="form-select" aria-label="State" id="sup_id" name="sup_id">
                                                
                                                @foreach ($model as $supplier)
                                                    <option value="{{ $supplier->sup_id }}"> [  ID : {{ $supplier->sup_id  }} ] Name : {{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="sup_id_error" class="form-text text-danger"></small>
                                        </div>




                                        <div class="col-md-6">
                                            <label class="mb-2" for="form-label">Transaction Type</label>
                                            <select class="form-select" aria-label="State" id="transaction_type" name="transaction_type" >
                                                
                                                <option value="1">سداد</option>
                                                <option value="2">سحب</option>
                                            </select>
                                            <small id="transaction_type_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Amount</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                required>
                                                <small id="amount_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </form><!-- End Multi Columns Form -->


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

            $('#sup_id_error').text('');
            $('#transaction_type_error').text('');
            $('#amount_error').text('');

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.supplier.transaction.store') }}",
                data: {
                    'sup_id': $("select[name='sup_id']").val(),
                    'transaction_type': $("select[name='transaction_type']").val(),
                    'amount': $("input[name='amount']").val(),
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
                    $.each(response.errors,function(key,val){
                        $("#" + key + "_error").text(val[0])
                    })
                }
            });
        });
    </script>
@endsection
