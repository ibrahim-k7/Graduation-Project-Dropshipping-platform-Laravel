@extends('User.layouts.main')

@section('pageTitle')
    تفاصيل الطلبات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>تفاصيل الطلبات</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="container-fluid ">
                <div class="row pt-5 justify-content-center ">
                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات الطلب</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">رقم الطلب:
                                    <span class="p-3 text-dark">2</span>
                                </p>
                                <p class="text-dark fs-5">تاريخ الطلب:
                                    <span class="p-3 text-dark">2020-12-21 sep </span>
                                </p>
                                <p class="text-dark fs-6 fw-bold">حالة الطلب:
                                    <span class="p-3 text-warning">kjhjhoi</span>
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-auto">
                        <div class="card ">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات العميل</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">اسم العميل:
                                    <span class="p-3 text-dark">محمد عبدالخالق</span>
                                </p>
                                <p class="text-dark fs-5">البريد الإلكتروني:
                                    <span class="p-3 text-dark">mohammed@gmial.com</span>
                                </p>
                                <p class="text-dark fs-5">العنوان:
                                    <span class="p-3 text-dark fs-6">kljflkwjevownvinsvohbsrbhisvkbosnb</span>
                                </p>
                                <p class="text-dark fs-5">رقم الجوال:
                                    <span class="p-3 text-dark">776273760</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">حالة الدفع</div>
                            <div class="card-body py-3 text-center">
                                <p class="text-danger fw-bolder mb-4">لم يتم الدفع</p>
                                <a href="#" class="btn btn-outline-success">أدفع</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row pt-5 justify-content-evenly ">

                    <div class="col col-lg-auto">
                        <div class="card w-auto">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">المنتجات</div>
                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table id="products" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th> المنتجات </th>
                                        <th>الكمية</th>
                                        <th>الوزن</th>
                                        <th>الوزن الاجمالي</th>
                                        <th>السعر</th>
                                        <th>المبلغ الفرعي</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-auto">
                        <div class="card ">
                            <div class="card-header text-center text-bg-light fs-5 fw-bold">مجموع الطلب</div>
                            <div class="card-body py-3 justify-content-end">
                                <p class="text-dark fs-5">المبلغ الفرعي:
                                    <span class="pe-3 text-dark">2500</span>
                                    ر.ي
                                </p>
                                <p class="text-dark fs-5">الوزن الإجمالي:
                                    <span class="pe-3 text-dark">0.4</span>
                                    kg
                                </p>
                                <p class="text-dark fs-5">رسوم الشحن:
                                    <span class="pe-3 text-dark">1000</span>
                                    ر.ي
                                </p>
                                <p class="text-dark fs-5">المجموع الكلي:
                                    <span class="pe-3 text-dark">6200</span>
                                    ر.ي
                                </p>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </section>


    </main><!-- End #main -->
@endsection
