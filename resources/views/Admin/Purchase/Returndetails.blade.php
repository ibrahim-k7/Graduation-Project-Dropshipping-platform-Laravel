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
        .purchase-details-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .purchase-details-table th,
        .purchase-details-table td {
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
    </style>
@endsection

@section('Content')
    <main id="main" class="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h5 class="mb-3"> معلومات الفاتورة</h5>
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
                                    <th>المجموع </th>
                                    <th>المدفوع </th>
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



                        <!-- زر الاسترجاع -->
                        <div class="return-button">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal">
                                فتح نافذة الاسترجاع
                            </button>
                        </div>

                        <!-- واجهة منبثقة للإسترجاع -->
                        <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="returnModalLabel">نافذة الاسترجاع</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- حقول الاسترجاع هنا -->


                                        <div class="mb-3">
                                            <label for="purchaseDetails">تفاصيل المشتريات:</label>
                                            <select class="form-select" aria-label="" id="purchaseDetails" name="purchaseDetails">
                                                <!-- خيار افتراضي غير قابل للاختيار -->
                                                <option value="" disabled selected>اختر تفاصيل المشتريات</option>
                                                <!-- استخدم البيانات التي تم عرضها في الصفحة لملء الخيارات -->
                                                @foreach($purchase->purchaseDetails as $purchaseDetail)
                                                    <option value="{{ $purchaseDetail->id }}">{{ $purchaseDetail->product->name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="purchaseDetails_error" class="form-text text-danger"></small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="return_date">تاريخ الاسترجاع:</label>
                                            <input type="date" class="form-control" id="return_date" name="return_date" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="quantity_returned">الكمية المسترجعة:</label>
                                            <input type="number" class="form-control" id="quantity_returned" name="quantity_returned" placeholder="ادخل الكمية المسترجعة" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="amount_returned">المبلغ المسترجع:</label>
                                            <input type="number" class="form-control" id="amount_returned" name="amount_returned" placeholder="ادخل المبلغ المسترجع" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" id="returnSubmit" class="btn btn-primary" onclick="processReturn()">استرجاع</button>
                                        </div>


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
                var purchaseData = @json($purchase ?? null);

                if (purchaseData != null) {
                    // عرض تفاصيل المشتريات في الجدول
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
                }

            }
        });

        // Function to handle the return process
        // Function to handle the return process
        function processReturn() {
            // Collect data from return fields
            var currentDate = new Date();
            var returnDate = currentDate.toISOString().slice(0, 19).replace("T", " ");

            var purchaseDetailsId = $('#purchaseDetails').val();
            var quantityReturned = $('#quantity_returned').val();
            var amountReturned = $('#amount_returned').val();

            // Get the available quantity for the selected purchase details
            var availableQuantity = parseInt($('#purchaseDetails option:selected').data('available-quantity'));

            // Check if the returned quantity is greater than the available quantity
            if (!returnDate) {
                alert('يرجى ملء حقل تاريخ الاسترجاع');
            } else if (!purchaseDetailsId) {
                alert('يرجى اختيار تفاصيل المنتج');
            } else if (!quantityReturned) {
                alert('يرجى ملء حقل الكمية المسترجعة');
            } else if (parseInt(quantityReturned) > availableQuantity) {
                alert('كمية الاسترجاع أكبر من الكمية المتاحة في الفاتورة.');
            } else if (!amountReturned) {
                alert('يرجى ملء حقل المبلغ المسترجع');
            } else {
                // Send data to the server using Ajax
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('admin.purchase.processReturn') }}",
                    data: {
                        purchase_details_id: purchaseDetailsId,
                        return_date: returnDate,
                        quantity_returned: quantityReturned,
                        amount_returned: amountReturned
                    },
                    success: function (response) {
                        // Successful operation
                        alert('تمت عملية الاسترجاع بنجاح');
                        $('#returnModal').modal('hide');
                        location.reload();
                    },
                    error: function (error) {
                        // An error occurred
                        alert('فشلت عملية الاسترجاع. يرجى المحاولة مرة أخرى.');
                        console.error(error);
                    }
                });
            }
        }

    </script>
@endsection
