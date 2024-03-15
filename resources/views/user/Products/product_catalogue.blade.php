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
            <h1>كتالوج المنتجات</h1>
         
        </div><!-- End Page Title -->

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">كتالوج المنتجات</h1>
                    <p class="lead fw-normal text-white-50 mb-0">جميع انواع المنتجات تجدها هنا</p>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-1 px-lg-1 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($products as $product)
                        <!-- Section-->

                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->

                                <img class="card-img-top" src="{{ asset('Products_img/' . $product->image) }}" alt="Product Image" width="150" height="150">

                                <!-- Product details-->

                                <div class="card-body p-3">

                                    <!-- Product name-->
                                    <p class="card-title p-1">{{ $product->name }}</p>

                                    <p class="card-text p-2">{{ $product->selling_price }}<span class="text-muted">ر.ي</span>
                                        <br>

                                        الفئة: {{ $product->categorie->name }}
                                        <br>

                                        الفئة: {{ $product->subCategorie->name }}
                                    </p>
                                    <!-- Product price-->


                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                            href="{{ route('user.product.details', ['id' => $product->id]) }}">
                                            عرض</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>

    </main><!-- End #main -->
@endsection
