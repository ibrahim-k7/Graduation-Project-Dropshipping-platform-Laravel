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
        <div class="row">
            <div class="col-lg-7" style="">
                <div class="card adv-card">
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-lg-12 ">
                                <div class="container">
                                    <div class="row cart_row mb-2 pb-0" style="">
                                        <div class="col-lg-6 p-0">
                                            <div class="row mb-3 ">
                                                <a href="#" class="col-md-3 col-3 nopadding">
                                                    <!-- <span class="cart_img" style=" background: url(https://d1gpzof0viq1mp.cloudfront.net/products/02192022005043621014b31ae2e.jpeg)  no-repeat center center / cover; "></span> -->

                                                </a>
                                                <div class="col-lg-9 col-9">
                                                    <div class="col-md-12 cart-title">
                                                    {{ $cartItems->product->name }}                                                    </div>
                                                    <div class="d-flex mt-5 ">
                                                        <a class=" md-visible remove_anchor ml-3 mr-3" href="https://m5azn.com/ar/seller/cart/remove/item/38602436" onclick="return confirm('Are you sure to remove item')">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                        <span class="cart_qty mr-3 ml-3">الكمية</span>
                                                        <div class="custom-select-container style-scope item-quantity-element ml-3 mr-3 ">
                                                            <select class="style-scope item-quantity-element qyt_select">
                                                                <template is="dom-repeat" restamp="true" as="option" class="style-scope item-quantity-element"></template>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mt-4 mr-auto">
                                            <p class="cart-price mb-3 md-visible">
                                                30 ر.س.
                                                <span>غير شامل الضريبة المضافة</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-0 border">
                <div class="p-4">
                    <h5 class="card-title mb-3">Guest checkout</h5>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <p class="mb-0">First name</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                            </div>
                        </div>

                        <div class="col-6">
                            <p class="mb-0">Last name</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <p class="mb-0">Phone</p>
                            <div class="form-outline">
                                <input type="tel" id="typePhone" value="+48 " class="form-control" />
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <p class="mb-0">Email</p>
                            <div class="form-outline">
                                <input type="email" id="typeEmail" placeholder="example@gmail.com" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">Keep me up to date on news</label>
                        </div> -->

                    <hr class="my-4" />

                    <h5 class="card-title mb-3">Shipping info</h5>

                    <div class="row mb-3">
                        <div class="col-lg-4 mb-3">
                            <!-- Default checked radio -->
                            <div class="form-check h-100 border rounded-3">
                                <div class="p-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked />
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Express delivery <br />
                                        <small class="text-muted">3-4 days via Fedex </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <!-- Default radio -->
                            <div class="form-check h-100 border rounded-3">
                                <div class="p-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" />
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Post office <br />
                                        <small class="text-muted">20-30 days via post </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <!-- Default radio -->
                            <div class="form-check h-100 border rounded-3">
                                <div class="p-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" />
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Self pick-up <br />
                                        <small class="text-muted">Come to our shop </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8 mb-3">
                            <p class="mb-0">Address</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <p class="mb-0">City</p>
                            <select class="form-select">
                                <option value="1">New York</option>
                                <option value="2">Moscow</option>
                                <option value="3">Samarqand</option>
                            </select>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <p class="mb-0">House</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" placeholder="Type here" class="form-control" />
                            </div>
                        </div>

                        <div class="col-sm-4 col-6 mb-3">
                            <p class="mb-0">Postal code</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" class="form-control" />
                            </div>
                        </div>

                        <div class="col-sm-4 col-6 mb-3">
                            <p class="mb-0">Zip</p>
                            <div class="form-outline">
                                <input type="text" id="typeText" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" />
                        <label class="form-check-label" for="flexCheckDefault1">Save this address</label>
                    </div>

                    <div class="mb-3">
                        <p class="mb-0">Message to seller</p>
                        <div class="form-outline">
                            <textarea class="form-control" id="textAreaExample1" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="float-end">
                        <button class="btn btn-light border">Cancel</button>
                        <button class="btn btn-success shadow-0 border">Continue</button>
                    </div>
                </div>
            </div>
            <!-- Checkout -->
        </div>
        <div class="col-xl-4 col-lg-4 d-flex justify-content-center justify-content-lg-end">
            <div class="ms-lg-4 mt-4 mt-lg-0" style="max-width: 320px;">
                <h6 class="mb-3">Summary</h6>
                <div class="d-flex justify-content-between">
                    <p class="mb-2">Total price:</p>
                    <p class="mb-2">$195.90</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-2">Discount:</p>
                    <p class="mb-2 text-danger">- $60.00</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-2">Shipping cost:</p>
                    <p class="mb-2">+ $14.00</p>
                </div>
                <hr />
                <div class="d-flex justify-content-between">
                    <p class="mb-2">Total price:</p>
                    <p class="mb-2 fw-bold">$149.90</p>
                </div>

                <div class="input-group mt-3 mb-4">
                    <input type="text" class="form-control border" name="" placeholder="Promo code" />
                    <button class="btn btn-light text-primary border">Apply</button>
                </div>

                <hr />
                <h6 class="text-dark my-4">Items in cart</h6>

                <div class="d-flex align-items-center mb-4">
                    <div class="me-3 position-relative">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                            1
                        </span>
                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/7.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
                    </div>
                    <div class="">
                        <a href="#" class="nav-link">
                            Gaming Headset with Mic <br />
                            Darkblue color
                        </a>
                        <div class="price text-muted">Total: $295.99</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="me-3 position-relative">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                            1
                        </span>
                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/5.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
                    </div>
                    <div class="">
                        <a href="#" class="nav-link">
                            Apple Watch Series 4 Space <br />
                            Large size
                        </a>
                        <div class="price text-muted">Total: $217.99</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="me-3 position-relative">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                            3
                        </span>
                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/1.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
                    </div>
                    <div class="">
                        <a href="#" class="nav-link">GoPro HERO6 4K Action Camera - Black</a>
                        <div class="price text-muted">Total: $910.00</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <div class=" container-fluid my-5 ">
            <div class="row justify-content-center ">
                <div class="col-xl-10">
                    <div class="card shadow-lg ">
                        <div class="row p-2 mt-3 justify-content-between mx-sm-2">
                            <div class="col">
                                <p class="text-muted space mb-0 shop"> Shop No.78618K</p>
                                <p class="text-muted space mb-0 shop">Store Locator</p>
                            </div>
                            <div class="col">
                                <div class="row justify-content-start ">
                                    <div class="col">
                                        <img class="irc_mi img-fluid cursor-pointer " src="https://i.imgur.com/jFQo2lD.png" width="70" height="70">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <img class="irc_mi img-fluid bell" src="https://i.imgur.com/uSHMClk.jpg" width="30" height="30">
                            </div>
                        </div>
                        <div class="row  mx-auto justify-content-center text-center">
                            <div class="col-12 mt-3 ">
                                <nav aria-label="breadcrumb" class="second ">
                                    <ol class="breadcrumb indigo lighten-6 first  ">
                                        <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="#"><span class="mr-md-3 mr-1">BACK TO SHOP</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href="#"><span class="mr-md-3 mr-1">SHOPPING BAG</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li>
                                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                        <div class="row justify-content-around">
                            <div class="col-md-5">
                                <div class="card border-0">
                                    <div class="card-header pb-0">
                                        <h2 class="card-title space ">Checkout</h2>
                                        <p class="card-text text-muted mt-4  space">SHIPPING DETAILS</p>
                                        <hr class="my-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col-auto mt-0">
                                                <p><b>BBBootstrap Team Vasant Vihar 110020 New Delhi India</b></p>
                                            </div>
                                            <div class="col-auto">
                                                <p><b>BBBootstrap@gmail.com</b> </p>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <p class="text-muted mb-2">PAYMENT DETAILS</p>
                                                <hr class="mt-0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="NAME" class="small text-muted mb-1">NAME ON CARD</label>
                                            <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="BBBootstrap Team">
                                        </div>
                                        <div class="form-group">
                                            <label for="NAME" class="small text-muted mb-1">CARD NUMBER</label>
                                            <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="4534 5555 5555 5555">
                                        </div>
                                        <div class="row no-gutters">
                                            <div class="col-sm-6 pr-sm-2">
                                                <div class="form-group">
                                                    <label for="NAME" class="small text-muted mb-1">VALID THROUGH</label>
                                                    <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="06/21">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="NAME" class="small text-muted mb-1">CVC CODE</label>
                                                    <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="183">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-md-5">
                                            <div class="col">
                                                <button type="button" name="" id="" class="btn  btn-lg btn-block ">PURCHASE $37 SEK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card border-0 ">
                                    <div class="card-header card-2">
                                        <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                                        <hr class="my-2">
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row  justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row">
                                                    <img class=" img-fluid" src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                    <div class="media-body  my-auto">
                                                        <div class="row ">
                                                            <div class="col-auto">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">1 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto  my-auto">
                                                <p class="boxed-1">2</p>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto  my-auto ">
                                                <p><b>179 SEK</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row  justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row">
                                                    <img class=" img-fluid " src="https://i.imgur.com/9MHvALb.jpg" width="62" height="62">
                                                    <div class="media-body  my-auto">
                                                        <div class="row ">
                                                            <div class="col">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto  my-auto">
                                                <p class="boxed">3</p>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p><b>179 SEK</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row  justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row">
                                                    <img class=" img-fluid " src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                    <div class="media-body  my-auto">
                                                        <div class="row ">
                                                            <div class="col">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto  my-auto">
                                                <p class="boxed-1">2</p>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p><b>179 SEK</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row ">
                                            <div class="col">
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p class="mb-1"><b>Subtotal</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>179 SEK</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <p class="mb-1"><b>Shipping</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>0 SEK</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p><b>Total</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>537 SEK</b></p>
                                                    </div>
                                                </div>
                                                <hr class="my-0">
                                            </div>
                                        </div>
                                        <div class="row mb-5 mt-4 ">
                                            <div class="col-md-7 col-lg-6 mx-auto"><button type="button" class="btn btn-block btn-outline-primary btn-lg">ADD GIFT CODE</button></div>
                                        </div>
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
<!-- <div class=" container-fluid my-5 ">
        <div class="row justify-content-center ">
            <div class="col-xl-10">
                <div class="card shadow-lg ">
                    <div class="row p-2 mt-3 justify-content-between mx-sm-2">
                        <div class="col">
                            <p class="text-muted space mb-0 shop"> Shop No.78618K</p>
                            <p class="text-muted space mb-0 shop">Store Locator</p>
                        </div>
                        <div class="col">
                            <div class="row justify-content-start ">
                                <div class="col">
                                    <img class="irc_mi img-fluid cursor-pointer " src="https://i.imgur.com/jFQo2lD.png" width="70" height="70">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <img class="irc_mi img-fluid bell" src="https://i.imgur.com/uSHMClk.jpg" width="30" height="30">
                        </div>
                    </div>
                    <div class="row  mx-auto justify-content-center text-center">
                        <div class="col-12 mt-3 ">
                            <nav aria-label="breadcrumb" class="second ">
                                <ol class="breadcrumb indigo lighten-6 first  ">
                                    <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="#"><span class="mr-md-3 mr-1">BACK TO SHOP</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                                    <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href="#"><span class="mr-md-3 mr-1">SHOPPING BAG</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li>
                                    <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row justify-content-around">
                        <div class="col-md-5">
                            <div class="card border-0">
                                <div class="card-header pb-0">
                                    <h2 class="card-title space ">Checkout</h2>
                                    <p class="card-text text-muted mt-4  space">SHIPPING DETAILS</p>
                                    <hr class="my-0">
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-auto mt-0">
                                            <p><b>BBBootstrap Team Vasant Vihar 110020 New Delhi India</b></p>
                                        </div>
                                        <div class="col-auto">
                                            <p><b>BBBootstrap@gmail.com</b> </p>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <p class="text-muted mb-2">PAYMENT DETAILS</p>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">NAME ON CARD</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="BBBootstrap Team">
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">CARD NUMBER</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="4534 5555 5555 5555">
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-sm-6 pr-sm-2">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">VALID THROUGH</label>
                                                <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="06/21">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">CVC CODE</label>
                                                <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="183">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-md-5">
                                        <div class="col">
                                            <button type="button" name="" id="" class="btn  btn-lg btn-block ">PURCHASE $37 SEK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border-0 ">
                                <div class="card-header card-2">
                                    <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                                    <hr class="my-2">
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row  justify-content-between">
                                        <div class="col-auto col-md-7">
                                            <div class="media flex-column flex-sm-row">
                                                <img class=" img-fluid" src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                <div class="media-body  my-auto">
                                                    <div class="row ">
                                                        <div class="col-auto">
                                                            <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">1 Week Subscription</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" pl-0 flex-sm-col col-auto  my-auto">
                                            <p class="boxed-1">2</p>
                                        </div>
                                        <div class=" pl-0 flex-sm-col col-auto  my-auto ">
                                            <p><b>179 SEK</b></p>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row  justify-content-between">
                                        <div class="col-auto col-md-7">
                                            <div class="media flex-column flex-sm-row">
                                                <img class=" img-fluid " src="https://i.imgur.com/9MHvALb.jpg" width="62" height="62">
                                                <div class="media-body  my-auto">
                                                    <div class="row ">
                                                        <div class="col">
                                                            <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pl-0 flex-sm-col col-auto  my-auto">
                                            <p class="boxed">3</p>
                                        </div>
                                        <div class="pl-0 flex-sm-col col-auto my-auto">
                                            <p><b>179 SEK</b></p>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row  justify-content-between">
                                        <div class="col-auto col-md-7">
                                            <div class="media flex-column flex-sm-row">
                                                <img class=" img-fluid " src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                <div class="media-body  my-auto">
                                                    <div class="row ">
                                                        <div class="col">
                                                            <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pl-0 flex-sm-col col-auto  my-auto">
                                            <p class="boxed-1">2</p>
                                        </div>
                                        <div class="pl-0 flex-sm-col col-auto my-auto">
                                            <p><b>179 SEK</b></p>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row ">
                                        <div class="col">
                                            <div class="row justify-content-between">
                                                <div class="col-4">
                                                    <p class="mb-1"><b>Subtotal</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>179 SEK</b></p>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col">
                                                    <p class="mb-1"><b>Shipping</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>0 SEK</b></p>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-4">
                                                    <p><b>Total</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>537 SEK</b></p>
                                                </div>
                                            </div>
                                            <hr class="my-0">
                                        </div>
                                    </div>
                                    <div class="row mb-5 mt-4 ">
                                        <div class="col-md-7 col-lg-6 mx-auto"><button type="button" class="btn btn-block btn-outline-primary btn-lg">ADD GIFT CODE</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
