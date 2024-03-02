@extends('User.Layouts.main')

@section('pageTitle')
إدارة المنتجات
@endsection

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Validation</h1>
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
            <div class="col-lg-6">

                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img id="dealer_product_image" src="{{ asset('Products_img/' . $details->product->image) }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"> {{ $details->product->name }}</h5>
                                <p class="card-text"><small class="text-body-secondary">Barcode: {{ $details->product->barcode}}</small></p>

                                <div class="mb-3">
                                    <span class="h5">تكلفة المنتج:</span>
                                    <span class="h5">{{ $details->product->selling_price }} ري </span>
                                    <span class="text-muted"> / للقطعة الواحدة </span>
                                </div>
                                <div class="mb-3">
                                    <span class="h5">السعر المقترح للبيع:</span>
                                    <span class="h5">{{ $details->product->suggested_selling_price }} ري </span>
                                    <span class="text-muted"> / للقطعة الواحدة </span>

                                </div>
                                <!-- <p class="card-text">{{ $details->dealer_product_desc }}</p> -->

                                <p class="card-text">الفئة الرئيسية: {{ $details->product->categorie->name }} </p>
                                <p class="card-text">الفئة الفرعية: {{ $details->product->subcategorie->name }} </p>


                                <p class="card-text"><small class="text-body-secondary">Last updated at {{ $details->updated_at }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-lg-6">

                <div class="col col-lg-auto">
                    <div class="card ">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات المنتج الخاصة بك</div>
                        <div class="card-body py-3 justify-content-end">
                            <form id="form" method="POST" class="row g-3">

                                <div class="col-md-12 mt-4">
                                    <label>اسم المنتج الخاص بك</label>
                                    <input type="text" class="form-control " id="dealer_product_name" name="dealer_product_name" required="">
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>السعر الخاص بك</label>
                                    <input type="text" class="form-control " id="dealer_selling_price" name="dealer_selling_price" required="">
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>وصف المنتج الخاص بك</label>
                                    <textarea type="text" class="form-control" id="dealer_product_desc" name="dealer_product_desc" style=" height: auto"></textarea>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <button type="submit" id="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="w-50 float-left card-title m-0" style="text-transform: capitalize"> Product Integrations </h3>
                    </div>
                    <div class="card-body">
                        <div id="pay-invoice">
                            <div class="card-body p-0 white_color">
                                <div class="col-sm-12 mt-2">
                                    <table class="display table table-striped table-bordered dataTable" style="width:100%">
                                        <thead>
                                            <tr role="row">
                                                <th>Platform </th>
                                                <th>Last Configuration </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td style="width:40px; text-align:center">
                                                    <img src="https://m5azn.com/assets/images/third_party/woo.png" style="max-width:70px;">
                                                </td>
                                                <td>
                                                    Not Configured
                                                </td>
                                                <td class="text-center">
                                                    <a href="" id="api_link">
                                                        <i class="fa fa-link fs-4"></i>
                                                    </a>
                                                    <span class="p-2"></span>
                                                    <a href="" id="api_unlink">
                                                        <i class="bi bi-trash link-danger fs-4"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
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
    $(document).ready(function() {
        var details = @json($details ?? null);

        $("#dealer_product_desc").val(details.dealer_product_desc);
        $("#dealer_product_name").val(details.dealer_product_name);
        $("#dealer_selling_price").val(details.dealer_selling_price);

        $(document).on('click','#api_link', function (e) {
            e.preventDefault();

            $.ajax({
                type:'post',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('WC.API.link.product') }}",
                data:{
                    'desc' : $("textarea[name='dealer_product_desc']").val() ,
                    'price' : $("input[name='dealer_selling_price']").val(),
                    'name' : $("input[name='dealer_product_name']").val(),
                    'image' : $("#dealer_product_image").attr('src'),
                },
                success: function () {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "تم ربط المنتج بنجاح",
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
                        title: "فشل ربط المنتج",
                        text:'المنتج مربوط بالمتجر مسبقاً',
                        showCloseButton: true,
                        showConfirmButton:false,
                    });
                }
            })
        });
        $(document).on('click', '#submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('user.dealer.product.update') }}",
                data: {
                    'id': details.dealer_pro_id,
                    'dealer_product_desc': $("textarea[name='dealer_product_desc']").val(),
                    'dealer_selling_price': $("input[name='dealer_selling_price']").val(),
                    'dealer_product_name': $("input[name='dealer_product_name']").val(),
                },
                success: function(data) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "تمت عملية التحديث بنجاح",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    console.log('suc: ' + data);
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
                        title: "فشلت عملية التحديث",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
        $(document).on('click','#api_unlink', function (e){
            e.preventDefault();

            $.ajax({
                type:'delete',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                url: "{{ route('WC.API.unlink.products') }}",
                data:{
                    'name' : $("input[name='dealer_product_name']").val(),
                },
                success:function (){
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "تم الغاء ربط المنتج",
                        showConfirmButton: false,
                        timer: 2000
                    })
                },
                error : function (reject) {
                    //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);


                    });
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "فشل الغاء ربط المنتج",
                        text:'المنتج غير مربوط بالمتجر مسيقاً',
                        showCloseButton: true,
                        showConfirmButton:false,
                    });
                }
            })
        });
    });
</script>
@endsection
