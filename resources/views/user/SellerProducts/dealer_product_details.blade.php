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
        <h1>إدارة المنتجات</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <!--  -->
    <section class="section">
        <div class="container-fluid ">
            <div class="row pt-5 justify-content-center ">
                <div class="col col-lg-auto">
                    <div class="card w-auto">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('Products_img/' . $details->product->image) }}" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"> {{ $details->product->name }}</h5>
                                        <p class="card-text"><small class="text-body-secondary">Barcode: {{ $details->product->barcode}}</small></p>

                                        <!-- <div class="mb-3">
                                            <span class="h5">تكلفة المنتج:</span>
                                            <span class="h5">{{ $details->product->selling_price }} ري </span>
                                            <span class="text-muted"> / للقطعة الواحدة </span>
                                        </div> -->
                                        <!-- <div class="mb-3">
                                            <span class="h5">السعر المقترح للبيع:</span>
                                            <span class="h5">{{ $details->product->suggested_selling_price }} ري </span>
                                        </div> -->
                                        <!-- <p class="card-text">{{ $details->dealer_product_desc }}</p> -->
                                        <p class="card-text">الفئة الرئيسية: {{ $details->product->categorie->name }} </p>
                                        <p class="card-text">الفئة الفرعية: {{ $details->product->subcategorie->name }} </p>


                                        <p class="card-text"><small class="text-body-secondary">Last updated at {{ $details->updated_at }}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-auto">
                    <div class="card ">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold"> سعر المنتج</div>
                        <div class="card-body py-3 justify-content-end">

                            <div class="col-md-12">
                                <label>تكلفة المنتج</label>
                                <input type="number" class="form-control " id="price" name="price" placeholder="" value="{{ $details->product->selling_price }}" readonly="">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>السعر الخاص بك</label>
                                <input type="text" class="form-control " id="sale_price" name="sale_price" value="{{ $details->dealer_selling_price }}" required="">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col col-lg-auto">
                    <div class="card ">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold"> اسم المنتج</div>
                        <div class="card-body py-3 justify-content-end">

                            <div class="col-md-12">
                                <label>اسم المنتج</label>
                                <input type="text" class="form-control " id="product_name" name="product_name" placeholder="" value="{{ $details->product->name }}" readonly="">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>اسم المنتج الخاص بك</label>
                                <input type="text" class="form-control " id="sale_price" name="sale_price" value="{{ $details->dealer_product_name }}" required="">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col col-lg-auto">
                    <div class="card ">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold"> اسم المنتج</div>
                        <div class="card-body py-3 justify-content-end">

                            <div class="col-md-12">
                                <label>وصف المنتج</label>
                                <input type="text" class="form-control " id="product_name" name="product_name" placeholder="" value="{{ $details->product->description }}" readonly="">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>وصف المنتج الخاص بك</label>
                                <input type="text" class="form-control " id="sale_price" name="sale_price" value="{{ $details->dealer_product_desc }}" required="">
                            </div>

                        </div>
                    </div>
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
                                        <td style="">
                                            Not Configured
                                        </td>
                                        <td>
                                            <a href="https://m5azn.com/ar/services/integration/woocommerce/products/38602436" class="text-success mr-2">
                                                <i class="fa fa-link"></i>
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
    </section>
</main><!-- End #main -->




<!-- <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content   ">
                <div class="breadcrumb d-flex mb-0">
                    <h1> كاس رج أحمر</h1>
                    <ul></ul>
                    <div class="col align-self-end">
                        <a class="btn btn-sm btn-warning  color_white cart-btn-adv float-right mr-2 ml-2 p-2 " href="https://m5azn.com/ar/seller/products/create"> <img src="https://m5azn.com/assets/images/new_icons/return-back.svg"></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <div class="owl-carousel">
                            <div class="item"><img class="prod-img img-fluid" src="https://d1gpzof0viq1mp.cloudfront.net/products/0131202412384365ba15231cc3e.jpg"></div>
                        </div>
                        <div class="product-badge-container">
                        </div>
                        <hr>
                        <div class="card adv-card mt-4 d-none">
                            <div class="card-body product-detail-adv">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الفئة </span>
                                            <span class="pro-att-detail">المكملات الغذائية</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> العلامة التجارية </span>
                                            <span class="pro-att-detail">N/A</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> SKU : </span>
                                            <span class="pro-att-detail">861033176215</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الباركود : </span>
                                            <span class="pro-att-detail">861033176215</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الوزن </span>
                                            <span class="pro-att-detail">0.4</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> سعر التكلفة : </span>
                                            <span class="pro-att-detail">8.76 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> سعر البيع </span>
                                            <span class="pro-att-detail">9.19 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> السعر المقترح : </span>
                                            <span class="pro-att-detail">15.62 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> وقت التوصيل </span>
                                            <span class="pro-att-detail">
                                                3-8 أيام
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الشحن </span>
                                            <span class="pro-att-detail">20 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> المخزون : </span>
                                            <span class="pro-att-detail">

                                                111
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mt-4">
                        <div class="card adv-card">
                            <div class="card-header ad-card-header">
                                <h3 class="w-100 float-left card-title m-0 ">
                                    <strong>الوصف :</strong>
                                </h3>
                                <hr class="mb-0">
                            </div>
                            <div class="card-body product-detail-adv">
                                <p>سهل الاستخدام .</p>
                                <p>مصنع من اجود المواد .</p>
                                <p>مزود بعلامات قياس.</p>
                                <p>سهولة حمله في اي مكان.</p>
                                <p>مقاوم للروائح والتصبغات.</p>
                            </div>
                        </div>
                        <div class="card adv-card mt-4">
                            <div class="card-body product-detail-adv">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الفئة </span>
                                            <span class="pro-att-detail">المكملات الغذائية</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> العلامة التجارية </span>
                                            <span class="pro-att-detail">N/A</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> SKU : </span>
                                            <span class="pro-att-detail">861033176215</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الباركود : </span>
                                            <span class="pro-att-detail">861033176215</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الوزن </span>
                                            <span class="pro-att-detail">0.4</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> سعر التكلفة : </span>
                                            <span class="pro-att-detail">9.19 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> سعر البيع </span>
                                            <span class="pro-att-detail">16 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> السعر المقترح : </span>
                                            <span class="pro-att-detail">15.62 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> وقت التوصيل </span>
                                            <span class="pro-att-detail">
                                                3-8 أيام
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> الشحن </span>
                                            <span class="pro-att-detail">20 ر.س.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex product-att-container">
                                            <span class="pro-att-heading"> المخزون : </span>
                                            <span class="pro-att-detail">

                                                111
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card adv-card-remove mt-4 ">
                            <div id="accordion" class="accordion">
                                <div class="card adv-card-remove">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <span class="acc-link-btn">التعليقات والتقيمات</span>
                                            </button>
                                        </h5>
                                        <div class="col align-self-end">
                                            <a class=" add-products-btn float-right  pl-4 pr-4">
                                                <span class="m-none text-black">0/5</span>
                                                <i class="fas fa-star active"></i>
                                            </a>
                                            <a class=" add-products-btn float-right  pl-4 pr-4">
                                                <img src="https://m5azn.com/assets/images/new_icons/comment-icons.svg" />
                                                <span class="m-none  text-black">0</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row mt-3">
                                                <p class="col-md-12 card-text card-comment-text txt-center w-100"> No Comments</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="do-comments">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card comment-card  mt-4">
                                                <div class="card-body p-0">
                                                    <div class="col-12 p-0">
                                                        <textarea name="comments" class="form-control comment-text-area" id="comments" cols="30" rows="5"
                                                            placeholder="اكتب هنا"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="card comment-card  mt-4" style="border-radius: 16px;
    padding: 0px 20px;">
                                                <div class="card-body p-0">
                                                    <div class="col-12 p-0">
                                                        <h3 class="w-100 d-flex justify-content-between card-title m-0">
                                                            <div class="w-100 d-flex">
                                                                <div class="mr-4">
                                                                    <h4>
                                                                        التقيم:
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="stars-rating m-0">
                                                                <span class="star-rating p-0  pb-2 mb-2 mt-0" id="starsType">
                                                                    <input type="radio" name="stars" class="stars" id="seller_star1" value="1"><i></i>
                                                                    <input type="radio" name="stars" class="stars" id="seller_star2" value="2"><i></i>
                                                                    <input type="radio" name="stars" class="stars" id="seller_star3" value="3"><i></i>
                                                                    <input type="radio" name="stars" class="stars" id="seller_star4" value="4"><i></i>
                                                                    <input type="radio" name="stars" class="stars" id="seller_star5" value="5"><i></i>
                                                                </span>
                                                            </div>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12">
                                            <a href class="btn  content_center payment_btn adv_button">إرسال</a>
                                        </div>
                                    </div>
                                    <div class="card  d-none mt-4">
                                        <div class="card-body">
                                            <div id="pay-invoice">
                                                <div class="card-body p-0">
                                                    <form id="comment_form" action="https://m5azn.com/en/catalog/product/comment" method="POST" class="row pl-3 pr-3">
                                                        <input type="hidden" name="_token" value="3L3LYcAAIkWJgB33I1qKTWhb79HsIXcsiEQTg9yw">
                                                        <div class="col-5 align-self-center rating">
                                                            <label for="rating" class="form-label">Your Rating:</label>
                                                        </div>
                                                        <div class="col-7 rating">
                                                            <span class="star-rating p-2" id="starsType">
                                                                <input type="radio" name="stars" class="stars" id="seller_star1" value="1"><i></i>
                                                                <input type="radio" name="stars" class="stars" id="seller_star2" value="2"><i></i>
                                                                <input type="radio" name="stars" class="stars" id="seller_star3" value="3"><i></i>
                                                                <input type="radio" name="stars" class="stars" id="seller_star4" value="4"><i></i>
                                                                <input type="radio" name="stars" class="stars" id="seller_star5" value="5"><i></i>
                                                            </span>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <input type="hidden" id="pid" value="338445" name="id">
                                                            <button class="btn btn-warning">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
@endsection