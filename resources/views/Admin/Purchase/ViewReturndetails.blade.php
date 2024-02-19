@extends('Admin.layouts.main')

@section('pageTitle')
    تفاصيل الفاتورة
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add your CSS styles here -->
    <style>
        /* Add your custom styles here */
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details-table,
        .purchase-details-table,
        .return-details-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-details-table th,
        .invoice-details-table td,
        .purchase-details-table th,
        .purchase-details-table td,
        .return-details-table th,
        .return-details-table td {
            text-align: center;
        }

        .total-amounts {
            margin-top: 20px;
            text-align: center;
        }

        .return-button {
            margin-top: 20px;
            text-align: center;
        }

        .mobile-design {
            /* Add your mobile design styles here */
        }

        .desktop-design {
            /* Add your desktop design styles here */
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            .invoice-details-table,
            .purchase-details-table,
            .return-details-table {
                overflow-x: auto;
            }
        }
    </style>
@endsection

@section('Content')
    <main id="main" class="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h5 class="mb-3">معلومات الفاتورة</h5>
                        </div>

                        <!-- عرض تفاصيل الفاتورة -->
                        <div class="invoice-details-table">
                            <h5 class="mb-3">تفاصيل الفاتورة:</h5>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>المورد</th>
                                    <th>طريقة الدفع</th>
                                    <th>التكلفة الإضافية</th>
                                    <th>المجموع</th>
                                    <th>المدفوع</th>
                                </tr>
                                </thead>
                                <tbody id="invoiceDetailsBody">
                                <!-- سيتم ملء هذا الجدول بتفاصيل الفاتورة -->
                                </tbody>
                            </table>
                        </div>

                        <!-- جدول تفاصيل المشتريات -->
                        <div id="purchaseDetailsTable">
                            <h5 class="mb-3">تفاصيل المشتريات:</h5>
                            <table class="table purchase-details-table">
                                <thead>
                                <tr>
                                    <th>رقم الصف</th>
                                    <th>اسم المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>التكلفة الإجمالية</th>
                                </tr>
                                </thead>
                                <tbody id="purchaseDetailsBody">
                                <!-- سيتم ملء هذا الجدول بتفاصيل المشتريات -->
                                </tbody>
                            </table>
                        </div>

                        <!-- جدول تفاصيل الفواتير المرتجعة -->
                        <div id="returnDetailsTable">
                            <h5 class="mb-3">تفاصيل الفواتير المرتجعة:</h5>
                            <table class="table return-details-table">
                                <thead>
                                <tr>
                                    <th>رقم الفاتورة المرتجعة</th>
                                    <th>رقم الصنف</th>
                                    <th>اسم المنتج</th>
                                    <th>تاريخ الاسترجاع</th>
                                    <th>الكمية المرتجعة</th>
                                    <th>المبلغ المرتجع</th>
                                </tr>
                                </thead>
                                <tbody id="returnDetailsBody">
                                <!-- سيتم ملء هذا الجدول بتفاصيل الفواتير المرتجعة -->
                                @php
                                    $displayedReturnDetails = [];
                                @endphp

                                @foreach($returnDetails as $details)
                                    @if(!in_array($details->purchase_details_id, $displayedReturnDetails))
                                        <tr>
                                            <td>{{ $details->purchase_details_id }}</td>
                                            <td>{{ $details->purchaseDetails->product->id }}</td>
                                            <td>{{ $details->purchaseDetails->product->name }}</td>
                                            <td>{{ $details->return_date }}</td>
                                            <td>{{ $details->quantity_returned }}</td>
                                            <td>{{ $details->amount_returned }}</td>
                                        </tr>
                                        @php
                                            $displayedReturnDetails[] = $details->purchase_details_id;
                                        @endphp
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        </div>
    </main>
@endsection


@section('js')
    <!-- Add your JS scripts here -->
    <script>

        // التحقق من حجم الشاشة وتحديد التصميم المناسب
        function checkScreenSize() {
            var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (screenWidth < 768) {
                // تحديد تصميم للهواتف المحمولة
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('mobile-design');
            } else {
                // تحديد تصميم للأجهزة اللوحية والحواسيب الشخصية
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('desktop-design');
            }
        }

        // تحقق من حجم الشاشة عند تحميل الصفحة
        window.onload = function() {
            checkScreenSize();
        };

        // تحقق من حجم الشاشة عند تغيير حجم النافذة
        window.onresize = function() {
            checkScreenSize();


        }





        $(document).ready(function () {
            $(document).ready(function () {
                var purchaseData = @json($purchase ?? null);

                if (purchaseData != null) {
                    // عرض تفاصيل الفاتورة
                    var invoiceDetailsBody = $('#invoiceDetailsBody');
                    invoiceDetailsBody.append('<tr>' +
                        '<td>' + purchaseData.id + '</td>' +
                        '<td>' + purchaseData.supplier.name + '</td>' +
                        '<td>' + purchaseData.payment_method + '</td>' +
                        '<td>' + purchaseData.additional_costs + '</td>' +
                        '<td>' + purchaseData.total + '</td>' +
                        '<td>' + purchaseData.amount_paid + '</td>' +
                        '</tr>');

                    // عرض تفاصيل المشتريات
                    var purchaseDetailsBody = $('#purchaseDetailsBody');
                    var purchaseDetails = @json($purchase->purchaseDetails ?? null);

                    if (purchaseDetails != null && purchaseDetails.length > 0) {
                        for (var i = 0; i < purchaseDetails.length; i++) {
                            purchaseDetailsBody.append('<tr>' +
                                '<td>' + purchaseDetails[i].product.id + '</td>' +
                                '<td>' + purchaseDetails[i].product.name + '</td>' +
                                '<td>' + purchaseDetails[i].product.price + '</td>' +
                                '<td>' + purchaseDetails[i].quantity + '</td>' +
                                '<td>' + purchaseDetails[i].total_cost + '</td>' +
                                '</tr>');
                        }
                    }

                    // عرض تفاصيل الفواتير المرتجعة
                    var returnDetailsBody = $('#returnDetailsBody');
                    var returnDetails = @json($returnDetails ?? null);
                    var displayedReturnDetails = []; // متغير لتخزين الفواتير المرتجعة التي تم عرضها

                    if (returnDetails != null && returnDetails.length > 0) {
                        for (var j = 0; j < returnDetails.length; j++) {
                            // التحقق من وجود الفاتورة المرتجعة و purchaseDetails و product قبل إضافتها
                            if (
                                returnDetails[j].purchaseDetails &&
                                returnDetails[j].purchaseDetails.product &&
                                returnDetails[j].purchaseDetails.product.id !== undefined &&
                                returnDetails[j].purchaseDetails.product.name !== undefined
                            ) {
                                var key = returnDetails[j].purchase_details_id + '|' + returnDetails[j].purchaseDetails.product.id;
                                if (!displayedReturnDetails.includes(key)) {
                                    displayedReturnDetails.push(key);

                                    returnDetailsBody.append('<tr>' +
                                        '<td>' + returnDetails[j].purchase_details_id + '</td>' +
                                        '<td>' + returnDetails[j].purchaseDetails.product.id + '</td>' +
                                        '<td>' + returnDetails[j].purchaseDetails.product.name + '</td>' +
                                        '<td>' + returnDetails[j].return_date + '</td>' +
                                        '<td>' + returnDetails[j].quantity_returned + '</td>' +
                                        '<td>' + returnDetails[j].amount_returned + '</td>' +
                                        '</tr>');
                                }
                            }
                        }
                    }
                }

                });
        });


    </script>

@endsection
