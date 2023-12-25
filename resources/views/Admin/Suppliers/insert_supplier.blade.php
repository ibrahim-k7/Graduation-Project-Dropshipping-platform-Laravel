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
            <h1>Insert New Supplier</h1>
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
                                    <h5 class="card-title">Supplier Form</h5>

                                    <!-- Multi Columns Form -->
                                    <form id="form" method="post" class="row g-3">
                                        @csrf
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Supplier Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="ibrahim Mohammed" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Supplier Email</label>
                                            <input type="twxt" class="form-control" id="email" name="email"
                                                placeholder="example@example.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Supplier Phone Number</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                placeholder="777777777" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Supplier Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="ibrahim Mohammed" required>

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
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('admin.suppliers.store') }}",
                data: {
                    'name': $("input[name='name']").val(),
                    'email': $("input[name='email']").val(),
                    'phone': $("input[name='phone']").val(),
                    'address': $("input[name='address']").val(),
                },
                success: function(data) {

                    $("#form")[0].reset();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "the new supplier has been saved",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // console.log('suc: ' + data);
                },
                error: function(data) {
                    // var error = data.responseJSON;
                    // console.log(error);

                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Email Already In Use.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    </script>
@endsection
