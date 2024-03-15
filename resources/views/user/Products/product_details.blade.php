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
                            <a data-product-id="{{ $details->id }}" id="buyNowBtn" class="btn btn-primary shadow-0"> <i
                                    class="ms-1 fa fa-shopping-basket"></i>
                                إضافة الى منتجاتي </a>
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
