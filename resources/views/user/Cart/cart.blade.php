@extends('User.Layouts.main')

@section('pageTitle')
    كتالوج المنتجات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>السلة</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <!-- Checkout -->



        <section class="section">
            <div class="container px-1 px-lg-1 mt-5">
                <form id="form" method="post">
                    <div class="row">


                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">Cart - 2 items</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Single item -->
                                    @foreach($product as $product)

                                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                <img src="{{ asset('Products_img/' . $product->image) }}" class="img-fluid rounded-3" alt="{{ $product->name }}">
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                <h6 class="text-muted">{{ $product->categorie->name }}</h6>
                                                <h6 class="text-black mb-0">{{ $product->name }}</h6>
                                            </div>
                                            <div class="col-md-2">
                                                <form id="quantityform" method="post">
                                                    <label for="quantity" class="form-label">الكمية</label>
                                                    <input type="hidden" class="pro_id" name="pro_id" value="{{ $product->id }}">
                                                    <input type="number" min="1" value="1" class="form-control quantity" name="quantity" placeholder="الكمية">
                                                    <small class="form-text text-danger quantity_error"></small>
                                                </form>

                                            </div>

                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                <label for="subAmountPerProduct" class="form-label">اجمالي سعر المنتج</label>
                                                <label class="subAmountPerProduct">{{ $product->selling_price }} / ري</label>
                                            </div>
                                            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                <a href="#!" class="text-muted"><i class="fas fa-times"></i></a>
                                            </div>
                                        </div>
                                        <hr class="my-4">

                                    @endforeach

                                    <!-- Single item -->
                                </div>
                            </div>

                            <!-- Checkout -->
                            <div class="card shadow-0 border">
                                <div class="p-4">
                                    <h5 class="card-title mb-3">معلومات الزبون</h5>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <p class="mb-0">الأسم كامل</p>
                                            <div class="form-outline">
                                                <input type="text" id="customer_name" name="customer_name" placeholder="اكتب هنا" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <p class="mb-0">رقم الهاتف</p>
                                            <div class="form-outline">
                                                <input type="tel" id="customer_phone" name="customer_phone" value="+967 " class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <p class="mb-0">الأيميل</p>
                                            <div class="form-outline">
                                                <input type="email" id="customer_email" name="customer_email" placeholder="example@gmail.com" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4" />

                                    <h5 class="card-title mb-3">معلومات الشحن</h5>

                                    <div class="row mb-3">
                                        @foreach($delivery as $key => $deliveryItem)
                                            <div class="col-lg-4 mb-3">
                                                <!-- Default checked radio for the first element -->
                                                <div class="form-check h-100 border rounded-3">
                                                    <div class="p-3">
                                                        <input class="form-check-input" type="radio" name="delivery_type{{$key}}" id="delivery_type{{$key}}" data-delivery-id="{{$deliveryItem->delivery_id}}" {{$key == 0 ? 'checked' : ''}} />
                                                        <label class="form-check-label" for="delivery_type{{$key}}">
                                                            {{$deliveryItem->name}} <br />
                                                            <small class="text-muted"> {{$deliveryItem->shipping_fees}} / ري </small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-8 mb-3">
                                            <p class="mb-0">العنوان</p>
                                            <div class="form-outline">
                                                <input type="text" id="shipping_address" name="shipping_address" placeholder="اكتب هنا" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-3">
                                            <p class="mb-0">المدينة</p>
                                            <select class="form-select" id="city">
                                                <option value="1">صنعاء</option>
                                            </select>
                                        </div>


                                    </div>




                                </div>
                            </div>
                            <!-- Checkout -->
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">ملخص الطلب</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                            المبلغ الفرعي
                                            <span class="subAmont">$53.98</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            رسوم الشحن
                                            <span class="deliveryCost">Gratis</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                            <div>
                                                <strong>المجموع</strong>

                                            </div>
                                            <span><strong class="totalAmount">$53.98</strong></span>
                                        </li>
                                    </ul>
                                    <button type="submit" id="addOrder" class="btn btn-primary shadow-0">إرسال</button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </section>






    </main><!-- End #main -->
@endsection

@section('js')
    <script>
        // عند تحميل الصفحة
        $(document).ready(function() {
            //var product = $('.product_id').val();
            // var selling_price =  $('#selling_price').val();;



            // var selling_price = parseInt(productId.selling_price);
            // var subCost = quantity * selling_price;
            // console.log(selling_price);
            // row.find('.subAmount').val(subCost.toFixed(2));

            // $('.quantity').on('input', updateAmount);

            $(document).on('input', '.quantity', function(e) {
                e.preventDefault();
                var row = $(this).closest('.row');

                var productId = parseInt(row.find('.pro_id').val()) || 0;
                var quantity = parseInt(row.find('.quantity').val()) || 0;
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('user.cart.calculateSubAmount') }}",
                    data: {
                        'pro_id': productId,
                        'quantity': quantity
                    },
                    success: function(data) {
                        row.find('.subAmountPerProduct').text(data + ' / ري'); // assuming data is a number


                    },
                    error: function(reject) {
                        //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق

                    }
                });


            })




            //عند الضغط على زر إرسال
            $(document).on('click', '#addOrder', function(e) {
                e.preventDefault();


                //    var quantity = parseInt(row.find('.quantity').val()) || 1;


                //حفظ المعلومات
                $.ajax({

                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('user.cart.addOrder') }}",
                    data: {
                        'customer_name': $("input[name='customer_name']").val(),
                        'customer_email': $("input[name='customer_email']").val(),
                        'customer_phone': $("input[name='customer_phone']").val(),
                        'lastname': $("input[name='lastname']").val(),
                        'delvery_id': $("input[name='delivery_type']:checked").data('delivery-id'),
                        'shipping_address': $("input[name='shipping_address']").val(),
                        // 'quantity': quantity,



                    },
                    success: function(data) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "تمت الإضافة بنجاح",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function(reject) {
                        //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "فشلت عملية الإضافة",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        });
    </script>
@endsection
