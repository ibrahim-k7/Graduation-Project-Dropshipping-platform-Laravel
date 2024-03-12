@extends('User.Layouts.main')

@section('pageTitle')
    لوحة التحكم
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>لوحة التحكم </h1>

            <nav>
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li> --}}
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Orders Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>تصفية</h6>
                                        </li>
                                        <li><a id="todayOrdersUser" class="dropdown-item" href="#">اليوم</a></li>
                                        <li><a id="thisMonthOrdersUser" class="dropdown-item" href="#">هذا الشهر</a>
                                        </li>
                                        <li><a id="thisYearOrdersUser" class="dropdown-item" href="#">هذا العام</a>
                                        </li>
                                        <li><a id="AllOrdersUser" class="dropdown-item" href="#">الكل</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">الطلبات <span id="orderDateUser">| هذا الشهر</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="ordersCountUser">0</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Orders Card -->

                        <!-- Wallet Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">


                                <div class="card-body">
                                    <h5 class="card-title">المحفظة <span>| الكل</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="balanceDash">0</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Wallet Card -->

                        <!-- Store Product Card -->
                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">


                                <div class="card-body">
                                    <h5 class="card-title">منتجاتك <span>| الكل</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="dealerProducts">0</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Store Product Card -->

                        <!-- مبيعاتك -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">مبيعاتك <span>/ المبالغ</span></h5>
                                    <div id="reportsChart"></div>
                                </div>

                            </div>
                        </div><!-- نهاية مبيعاتك -->



                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">


                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">الطلبات <span>| الاخيره</span></h5>

                                <div class="table-responsive">
                                    <!-- Table with stripped rows -->
                                    <table id="lastOrdersTableUser" class="table table-striped">
                                        <thead>

                                            <tr>
                                                <th>ID</th>
                                                <th>المنصة</th>
                                                <th>العميل</th>
                                                <th>الإجمالي</th>
                                                <th>حالة الدفع</th>
                                                <th>حالة الطلب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>

                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->


                    {{-- <!-- Website Traffic -->
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">Website Traffic <span>| Today</span></h5>

                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>


                        </div>
                    </div><!-- End Website Traffic --> --}}


                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            function initializeOrders() {
                // افتراضياً، قم بتشغيل الدالة عندما يتم تحميل الصفحة
                fetchData('thisMonth');


                // استمع لحدث النقر على الروابط وقم بتشغيل الدالة المناسبة
                $('#todayOrdersUser').click(function() {
                    fetchData('today');
                    $('#orderDateUser').text('| اليوم');
                });

                $('#thisMonthOrdersUser').click(function() {
                    fetchData('thisMonth');
                    $('#orderDateUser').text('| هذا الشهر')
                });

                $('#thisYearOrdersUser').click(function() {
                    fetchData('thisYear');
                    $('#orderDateUser').text('| هذا العام')
                });

                $('#AllOrdersUser').click(function() {
                    fetchData('all');
                    $('#orderDateUser').text('| الكل')

                });

                // دالة لجلب البيانات باستخدام AJAX
                function fetchData(timeframe) {
                    var storeId = "{{ Auth::user()->store_id }}";
                    var url = "{{ route('user.order.getOrdersCount') }}?timeframe=" + timeframe + "&store_id=" +
                        storeId;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#ordersCountUser').text(data.count);
                        },
                        error: function(error) {
                            console.error(' فشل في جلب عدد الطلبات :', error);
                        }
                    });
                }
            }

            // استدعاء دالة الطلبات
            initializeOrders();


            $.ajax({
                type: 'get',
                url: "{{ route('user.wallet.getBalance') }}",
                async: false,
                success: function(data) {
                    // استخدام قيمة $wallet الفعلية التي تم استرجاعها من الخادم
                    var balanceValue = data.balance;
                    $("#balanceDash").html(balanceValue +
                        '<span style="font-size: small ;"> ري</span>');
                },
                error: function(reject) {
                    console.error('Error loading :', reject);
                }
            });

            $.ajax({
                type: 'get',
                url: "{{ route('user.dealer.product.getDealerProductsCount') }}",
                async: false,
                success: function(data) {
                    $('#dealerProducts').text(data.count);
                },
                error: function(reject) {
                    console.error('Error loading :', reject);
                }
            });

            $('#lastOrdersTableUser').DataTable({
                ajax: {
                    url: "{{ route('user.order.getOrders') }}",
                    type: 'GET',
                    data: function(d) {
                        // قم بإضافة معلومات إضافية إلى الطلب هنا
                        d.store_id = {{ Auth::user()->store_id }};
                    },
                    dataType: 'json',
                    dataSrc: ''
                },

                "autoWidth": false,
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],

                "lengthMenu": [10,15], // الخيارات المتاحة للمستخدم
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all', //كل الحقول
                    className: 'dt-right' //الاتجاه
                }],
                columns: [{
                        data: 'order_id',
                        title: '#'
                    },
                    {
                        data: 'platform',
                        title: 'المنصة'
                    },
                    {
                        data: 'customer_name',
                        title: 'العميل'
                    },
                    {
                        data: 'total_amount',
                        title: 'الاجمالي'
                    },
                    {
                        data: 'order_status',
                        title: 'حالة الطلب',
                        render: function(data, type, row, meta) {
                            var badgeClass = '';
                            if (data == 'تم التوصيل') {
                                badgeClass = 'bg-success';
                            } else if (data == 'تم الغاء الطلب') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-warning';
                            }
                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'payment_status',
                        title: 'حالة الدفع',
                        render: function(data, type, row, meta) {
                            var badgeClass = '';
                            if (data == 'تم الدفع') {
                                badgeClass = 'bg-success';
                            } else if (data == 'تم الغاء الدفع') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-warning';
                            }
                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    }
                    // يمكنك إضافة المزيد من الأعمدة حسب احتياجاتك
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json" // تحميل ملف اللغة العربية
                }
            });

            // // في ملف النص البرمجي الخاص بك
            // var options = {
            //     chart: {
            //         type: 'line'
            //     },
            //     series: [{
            //         name: 'sales',
            //         data: []
            //     }],
            //     xaxis: {
            //         categories: []
            //     }
            // }

            // var chart = new ApexCharts(document.querySelector("#ccqq"), options);

            // // جلب البيانات عبر AJAX
            // $.ajax({
            //     url: "/get-chart-data",
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(data) {
            //         // تحديث البيانات في الـ chart
            //         chart.updateSeries([{
            //             data: data.salesData
            //         }]);
            //         chart.updateOptions({
            //             xaxis: {
            //                 categories: data.categories
            //             }
            //         });
            //     },
            //     error: function(error) {
            //         console.error('خطأ في جلب البيانات:', error);
            //     }
            // });

            // chart.render();


            // إعداد options الأساسية للـ ApexCharts
            var options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                    name: '( المبلغ )',
                    data: []
                }],
                markers: {
                    size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: []
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                }
            };

            // إنشاء كائن ApexCharts باستخدام الخيارات الأساسية
            var chart = new ApexCharts(document.querySelector("#reportsChart"), options);

            // جلب البيانات عبر AJAX
            $.ajax({
                url: "/get-chart-data",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث البيانات في الـ chart
                    chart.updateSeries([{
                        data: data.salesData
                    }]);
                    chart.updateOptions({
                        xaxis: {
                            categories: data.categories
                        }
                    });
                },
                error: function(error) {
                    console.error('خطأ في جلب البيانات:', error);
                }
            });

            // عرض الـ chart
            chart.render();






        });
    </script>
@endpush
