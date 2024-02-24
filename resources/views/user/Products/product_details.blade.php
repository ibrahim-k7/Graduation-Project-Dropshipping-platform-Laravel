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
                            <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                                href="">
                                <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                    src="{{ asset('Products_img/' . $details->image) }}" />
                            </a>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                        </div>
                        <!-- thumbs-wrap.// -->
                        <!-- gallery-wrap .end// -->
                    </aside>
                    <main class="col-lg-6">
                        <div class="ps-lg-3">
                            <h4 class="title text-dark">
                                {{ $details->name }} <br />
                                <h6>الفئة : {{ $details->subCategorie->name }} / {{ $details->categorie->name }} </h6>
                            </h4>
                            {{-- <div class="d-flex flex-row my-3">
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
                                <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>
                                    {{ $details->quantity }} </span>
                                <span class="text-success me-2">الكيمة المتوفره</span>
                            </div> --}}
                            {{-- 
                            <div class="mb-3">
                                <span class="h5">{{ $details->selling_price }}</span>
                                <span class="text-muted">ر.ي </span>
                            </div> --}}
                            {{-- 
                        <p>
                            {{ $details->description }}
                        </p> --}}

                            <div class="row">
                                <dt class="col-4">الوصف :</dt>
                                <dd class="col-8"> {{ $details->description }}</dd>

                                <dt class="col-4">الباركود :</dt>
                                <dd class="col-8">{{ $details->barcode }}</dd>

                                <dt class="col-4">الوزن :</dt>
                                <dd class="col-8">{{ $details->weight }} <span class="text-muted">/ جرام</span></dd>

                                <dt class="col-4">سعر البيع :</dt>
                                <dd class="col-8">{{ $details->selling_price }} <span class="text-muted">ر.ي </span>
                                </dd>

                                <dt class="col-5">سعر البيع المقترح :</dt>
                                <dd class="col-7">{{ $details->suggested_selling_price }} <span class="text-muted">ر.ي
                                    </span></dd>
                            </div>

                            <div class="d-flex flex-row my-3">
                                <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>
                                    {{ $details->quantity }} </span>
                                <span class="text-success me-2">الكيمة المتوفره</span>
                            </div>

                            <hr />
{{-- 
                            <div class="row mb-4">
                                <div class="col-md-4 col-6">
                                    <label class="mb-2">Size</label>
                                    <select class="form-select border border-secondary" style="height: 35px;">
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <label class="mb-2 d-block">Quantity</label>
                                    <div class="input-group mb-3" style="width: 170px;">
                                        <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon1" data-mdb-ripple-color="dark">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center border border-secondary"
                                            placeholder="14" aria-label="Example text with button addon"
                                            aria-describedby="button-addon1" />
                                        <button class="btn btn-white border border-secondary px-3" type="button"
                                            id="button-addon2" data-mdb-ripple-color="dark">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}

                            <a data-product-id="{{ $details->id }}" id="buyNowBtn" class="btn btn-primary shadow-0"> <i
                                    class="ms-1 fa fa-shopping-basket"></i>
                                إضافة الى منتجاتي </a>
                            {{-- <a href="#" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i>
                                Add to cart </a> --}}

                        </div>
                    </main>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // استمع لحدث النقر على الزر
            $('#buyNowBtn').click(function(event) {
                event.preventDefault(); // لمنع سلوك الرابط الافتراضي

                // استرجاع معرف المنتج من البيانات المخزنة في الزر
                var productId = $(this).data('product-id');

                // إجراء طلب AJAX
                $.ajax({
                    url: "{{ route('user.add.dealer.product') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    data: {
                        'id': productId
                    },

                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "تمت عملية الإضافة بنجاح",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "المنتج موجود بالفعل",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        });
    </script>
@endpush
