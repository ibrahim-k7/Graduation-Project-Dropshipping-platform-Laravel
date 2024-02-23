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
        /* تصميم الهواتف المحمولة */
        @media (max-width: 767px) {
            #main.mobile-design {
                /* إضافة أنماط CSS للهواتف المحمولة هنا */
            }
        }

        /* تصميم الأجهزة اللوحية والحواسيب الشخصية */
        @media (min-width: 768px) {
            #main.desktop-design {
                /* إضافة أنماط CSS للأجهزة اللوحية والحواسيب الشخصية هنا */
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
                                    <th>العملية</th>
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
                                            <td>{{ $details->return_id }}</td>
                                            <td>{{ $details->purchase_details_id }}</td>
                                            <td>{{ $details->purchaseDetails->product->name }}</td>
                                            <td>{{ $details->return_date }}</td>
                                            <td>{{ $details->quantity_returned }}</td>
                                            <td>{{ $details->amount_returned }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete-return-btn" data-return-id="{{ $details->return_id }}">حذف</button>
                                            </td>
                                        </tr>
                                        @php
                                            $displayedReturnDetails[] = $details->purchase_details_id;
                                        @endphp
                                    @endif
                                @endforeach
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
                                            <label for="purchaseDetails">المنتج:</label>
                                            <select class="form-select" aria-label="" id="purchaseDetails" name="purchaseDetails">
                                                <!-- خيار افتراضي غير قابل للاختيار -->
                                                <option value="" disabled selected>اختر تفاصيل المشتريات</option>
                                                <!-- استخدم البيانات التي تم عرضها في الصفحة لملء الخيارات -->
                                                @foreach($purchase->purchaseDetails as $purchaseDetail)
                                                    <option value="{{ $purchaseDetail->id }}"
                                                            data-unit-price="{{ $purchaseDetail->product->purchasing_price }}">
                                                        {{ $purchaseDetail->product->name }}
                                                    </option>
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
                                            <input type="number" class="form-control" id="amount_returned" name="amount_returned" placeholder="ادخل المبلغ المسترجع" readonly>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" id="returnSubmit" class="btn btn-primary">استرجاع</button>
                                        </div>
                                    </div>
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
                                '<td>' + purchaseDetails[i].product.purchasing_price + '</td>' +
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
                                        '<td>' + returnDetails[j].purchaseDetails.product.name + '</td>' +
                                        '<td>' + returnDetails[j].return_id + '</td>' +
                                        '<td>' + returnDetails[j].return_date + '</td>' +
                                        '<td>' + returnDetails[j].quantity_returned + '</td>' +
                                        '<td>' + returnDetails[j].amount_returned + '</td>' +
                                        '<td>' +
                                        '<button type="button" class="btn btn-danger btn-sm delete-return-btn" data-id="' + returnDetails[j].id + '">حذف</button>' +
                                        '</td>' +
                                        '</tr>');
                                }
                            }
                        }
                    }
                }
        });

        // عند تغيير تفاصيل المنتج
        $('#purchaseDetails').on('change', function() {
            // تحديث سعر المنتج (unitPrice)
            var unitPrice = parseFloat($(this).find(':selected').data('unit-price'));
            $('#amount_returned').val('');  // إعادة تعيين قيمة المبلغ المسترجع

            // تحديث قيم الحقول
            $('#quantity_returned').trigger('change');
        });

        // عند تغيير قيمة الكمية المسترجعة
        $('#quantity_returned').on('change', function() {
            // حساب المبلغ المسترجع باستخدام سعر المنتج والكمية المسترجعة
            var unitPrice = parseFloat($('#purchaseDetails').find(':selected').data('unit-price'));
            var quantityReturned = parseFloat($(this).val());
            var amountReturned = quantityReturned * unitPrice;

            // إضافة السعر المسترجع إلى الصفحة
            $('#amount_returned').val(amountReturned.toFixed(2)); // تحديد عدد الأرقام بعد الفاصلة العشرية
        });

        $(document).on('click', '#returnSubmit', function(e) {
            // Function to handle the return process

            // Collect data from return fields
            var currentDate = new Date();
            var returnDate = currentDate.toISOString().slice(0, 19).replace("T", " ");

            var purchaseDetailsId = $('#purchaseDetails').val();
            var quantityReturned = $('#quantity_returned').val();
            var amountReturned = $('#amount_returned').val();

            // Get the available quantity for the selected purchase details
            var availableQuantity = parseInt($('#purchaseDetails option:selected').data('available-quantity'));
            // Get the purchased quantity for the selected purchase details
            var purchasedQuantity = parseInt($('#purchaseDetails option:selected').data('purchased-quantity'));

            // Initialize a variable to determine whether to send data to the server
            var sendData = true;

            // Check for errors
            if (!returnDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجى ملء حقل تاريخ الاسترجاع',
                });
                sendData = false;
            } else if (!purchaseDetailsId) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجى اختيار تفاصيل المنتج',
                });
                sendData = false;
            } else if (!quantityReturned) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجى ملء حقل الكمية المسترجعة',
                });
                sendData = false;
            } else if (parseInt(quantityReturned) > availableQuantity || parseInt(quantityReturned) > purchasedQuantity) {
                Swal.fire({
                    icon: 'error',
                    title: 'كمية الاسترجاع أكبر من الكمية المتاحة أو المشتراة في الفاتورة.',
                });
                sendData = false;
            } else if (!amountReturned) {
                Swal.fire({
                    icon: 'error',
                    title: 'يرجى ملء حقل المبلغ المسترجع',
                });
                sendData = false;
            }

            // Send data to the server using Ajax only if sendData is true
            if (sendData) {
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
                    success: function(response) {
                        console.log(response); // طباعة الرد في وحدة التحكم

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تمت عملية الاسترجاع بنجاح',
                            }).then(() => {
                                $('#returnModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'فشلت عملية الاسترجاع',
                                text: 'يرجى المحاولة مرة أخرى.',
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'فشلت عملية الاسترجاع',
                            text: 'يرجى المحاولة مرة أخرى.',
                        });
                        console.error(error);
                    }
                });
            }
        });
            // الدالة الفرعية
            $(document).on('click', '.delete-return-btn', function(e) {
                e.preventDefault();

                var return_id = $(this).data('return-id');
                console.log('return_id:', return_id);

                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع عن هذا",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "تراجع",
                    confirmButtonText: "نعم، احذفه"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                            },
                            url: "{{ route('admin.returnDetails.destroy') }}",
                            data: {
                                'return_id': return_id
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "تم الحذف",
                                    text: "تم حذف الملف بنجاح",
                                    icon: "success"
                                });

                                // إعادة تحميل الصفحة بعد الحذف
                                location.reload();
                                },
                            error: function(reject) {
                                var errorMessage = reject.responseJSON && reject.responseJSON.message ? reject.responseJSON.message : 'حدث خطأ أثناء معالجة الاسترجاع.';
                                Swal.fire({
                                    title: "خطأ",
                                    text: errorMessage,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

        });

    </script>
@endsection
