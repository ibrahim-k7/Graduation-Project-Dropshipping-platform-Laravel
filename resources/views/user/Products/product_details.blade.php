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
        <h1>تفاصيل المنتج</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="{{asset('Products_img/'. $details-> image)}}" />
                        </a>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="{{asset('Products_img/'. $details-> image)}}" />
                        </a>
                    </div>
                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                           {{$details-> name}} <br />
                            Casual Hoodie
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                            <span class="text-success ms-2">In stock</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5">${{$details -> selling_price}}</span>
                            <span class="text-muted">/per box</span>
                        </div>

                        <p>
                        {{$details -> description}} 
                        </p>

                        <div class="row">
                            <dt class="col-3">Type:</dt>
                            <dd class="col-9">Regular</dd>

                            <dt class="col-3">Color</dt>
                            <dd class="col-9">Brown</dd>

                            <dt class="col-3">Material</dt>
                            <dd class="col-9">Cotton, Jeans</dd>

                            <dt class="col-3">Brand</dt>
                            <dd class="col-9">Reebook</dd>
                        </div>

                        <hr />

                        <div class="row mb-4">
                            <div class="col-md-4 col-6">
                                <label class="mb-2">Size</label>
                                <select class="form-select border border-secondary" style="height: 35px;">
                                    <option>Small</option>
                                    <option>Medium</option>
                                    <option>Large</option>
                                </select>
                            </div>
                            <!-- col.// -->
                            <div class="col-md-4 col-6 mb-3">
                                <label class="mb-2 d-block">Quantity</label>
                                <div class="input-group mb-3" style="width: 170px;">
                                    <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon1" data-mdb-ripple-color="dark">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" class="form-control text-center border border-secondary" placeholder="14" aria-label="Example text with button addon" aria-describedby="button-addon1" />
                                    <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('user.add.dealer.product',['id'=>$details->id])}}" class="btn btn-warning shadow-0" > Buy now </a>
                        <a href="#" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i> Add to cart </a>
                        <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Save </a>
                    </div>
                </main>
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
                                                <textarea name="comments" class="form-control comment-text-area" id="comments" cols="30" rows="5" placeholder="اكتب هنا"></textarea>
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