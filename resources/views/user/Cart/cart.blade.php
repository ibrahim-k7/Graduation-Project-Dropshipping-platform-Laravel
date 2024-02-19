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
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Cart - 2 items</h5>
                        </div>
                        <div class="card-body">
                            <!-- Single item -->
                            @foreach($product as $product)
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="{{ asset('Products_img/' . $product->image) }}" class="w-100" alt="" />
                                        <a href="#!">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                        </a>
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong>{{ $product->name }}</strong></p>
                                    <p>Categorie: <small>{{ $product->categorie->name }}</small></p>
                                    <p>Sub Categorie: <small>{{ $product->subCategorie->name }}</small></p>
                                    <button type="button" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip" title="Remove item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm mb-2" data-mdb-toggle="tooltip" title="Move to the wish list">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <!-- Data -->
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <button class="btn btn-primary px-3 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <div class="form-outline">
                                            <input id="form1" min="0" name="quantity" value="1" type="number" class="form-control" />
                                            <label class="form-label" for="form1">Quantity </label>
                                        </div>

                                        <button class="btn btn-primary px-3 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Quantity -->

                                    <!-- Price -->
                                    <p class="text-start text-md-center">
                                        <strong>{{ $product->selling_price }} / ري</strong>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>

                            <!-- Single item -->

                            <hr class="my-4" />
                            @endforeach

                            <!-- Single item -->
                        </div>
                    </div>

                    <!-- Checkout -->
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

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">Keep me up to date on news</label>
                            </div>

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

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Products
                                    <span>$53.98</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Shipping
                                    <span>Gratis</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                        <strong>
                                            <p class="mb-0">(including VAT)</p>
                                        </strong>
                                    </div>
                                    <span><strong>$53.98</strong></span>
                                </li>
                            </ul>

                            <button type="button" class="btn btn-primary btn-lg btn-block">
                                Go to checkout
                            </button>
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
