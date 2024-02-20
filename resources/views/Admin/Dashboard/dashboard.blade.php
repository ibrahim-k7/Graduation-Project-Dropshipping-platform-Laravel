@extends('Admin.layouts.main')

@section('pageTitle')
    لوحة التحكم
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>لوحة التحكم</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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

                                        <li><a id="todayOrders" class="dropdown-item" href="#">اليوم</a></li>
                                        <li><a id="thisMonthOrders" class="dropdown-item" href="#">هذا الشهر</a></li>
                                        <li><a id="thisYearOrders" class="dropdown-item" href="#">هذا العام</a></li>
                                        <li><a id="AllOrders" class="dropdown-item" href="#">الكل</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">الطلبات <span id="orderDate">| اليوم</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="ordersCount">0</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Orders Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>تصفية</h6>
                                        </li>

                                        <li><a id="todaySales" class="dropdown-item" href="#">اليوم</a></li>
                                        <li><a id="thisMonthSales" class="dropdown-item" href="#">هذا الشهر</a></li>
                                        <li><a id="thisYearSales" class="dropdown-item" href="#">هذا العام</a></li>
                                        <li><a id="AllSales" class="dropdown-item" href="#">الكل</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">المبيعات <span id="salesDate">| هذ الشهر</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="totalSales">0</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card debt-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>تصفية</h6>
                                        </li>
                                        <li><a id="todayBalance" class="dropdown-item" href="#">اليوم</a></li>
                                        <li><a id="thisMonthBalance" class="dropdown-item" href="#">هذا الشهر</a></li>
                                        <li><a id="thisYearBalance" class="dropdown-item" href="#">هذا العام</a></li>
                                        <li><a id="allBalance" class="dropdown-item" href="#">الكل</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">المديونية <span id="balanceDate">| هذا العام</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="totalBalanceCount">0</h6>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card products-card">
                                <div class="card-body">
                                    <h5 class="card-title">المنتجات <span>| الكل</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <div class="pe-3" id="productsCountContainer">
                                            <h6 id="productsCount">0</h6>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">المتاجر <span>| الكل</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="storeCount">0</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card suppliers-card">
                                <div class="card-body">
                                    <h5 class="card-title">الموردين <span>| الكل</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-briefcase"></i>
                                        </div>
                                        <div class="pe-3">
                                            <h6 id="suppliersCount">0</h6>
                                            {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                                class="text-muted small pt-2 ps-1">decrease</span> --}}

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">



                                <div class="card-body">
                                    <h5 class="card-title">مبالغ الطلبات و المبيعات<span> / الكل</span></h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>

                                    {{-- <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            new ApexCharts(document.querySelector("#reportsChart"), {
                                                series: [{
                                                    name: 'الطلبات',
                                                    data: [31, 40, 28, 51, 42, 82, 56, 56],
                                                }, {
                                                    name: 'المبيعات',
                                                    data: [11, 32, 45, 32, 34, 52, 41, 56]
                                                }, {
                                                    name: 'المتاجر',
                                                    data: [15, 11, 32, 18, 9, 24, 11, 56]
                                                }],
                                                chart: {
                                                    height: 350,
                                                    type: 'area',
                                                    toolbar: {
                                                        show: false
                                                    },
                                                },
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
                                                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                                        "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                                        "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                                        "2018-09-19T06:30:00.000Z", "2018-09-19T07:30:00.000Z"
                                                    ]
                                                },
                                                tooltip: {
                                                    x: {
                                                        format: 'dd/MM/yy HH:mm'
                                                    },
                                                }
                                            }).render();
                                        });
                                    </script> --}}
                                    <!-- End Line Chart -->

                                </div>

                            </div>
                        </div><!-- End Reports -->


                        <!-- Website Traffic -->
                        <div class="card">

                            <div class="card-body pb-0">
                                <h5 class="card-title">المبيعات VS المديونية <span> / الكل </span></h5>

                                <div id="trafficChart" style="min-height: 400px;" class="echart"></div>


                            </div>
                        </div><!-- End Website Traffic -->



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
                                    <table id="lastOrdersTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>المتجر</th>
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

                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">المنتجات <span>| ذات الكميات القليلة</span></h5>


                                <div class="table-responsive">
                                    <!-- Table with stripped rows -->
                                    <table id="lowQuantityProducts" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>صورة</th>
                                                <th>المنتج</th>
                                                <th>الكمية</th>
                                                <th>الباركود</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>

                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->



                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            function initializeOrders() {
                // افتراضياً، قم بتشغيل الدالة عندما يتم تحميل الصفحة
                fetchData('today');


                // استمع لحدث النقر على الروابط وقم بتشغيل الدالة المناسبة
                $('#todayOrders').click(function() {
                    fetchData('today');
                    $('#orderDate').text('| اليوم');
                });

                $('#thisMonthOrders').click(function() {
                    fetchData('thisMonth');
                    $('#orderDate').text('| هذا الشهر')
                });

                $('#thisYearOrders').click(function() {
                    fetchData('thisYear');
                    $('#orderDate').text('| هذا العام')
                });

                $('#AllOrders').click(function() {
                    fetchData('all');
                    $('#orderDate').text('| الكل')

                });

                // دالة لجلب البيانات باستخدام AJAX
                function fetchData(timeframe) {
                    var url = "{{ route('admin.order.getOrdersCount') }}?timeframe=" + timeframe;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#ordersCount').text(data.count);
                        },
                        error: function(error) {
                            console.error(' فشل في جلب عدد الطلبات :', error);
                        }
                    });
                }
            }

            // استدعاء دالة المبيعات
            initializeOrders();

            // عدد الطلبات
            // $.ajax({
            //     url: "{{ route('admin.order.getOrdersCount') }}",
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(data) {
            //         // تحديث القيمة
            //         $('#ordersCount').text(data.count);
            //     },
            //     error: function(error) {
            //         console.error(' فشل جلب عدد الطلبات :', error);
            //     }
            // });


            // عدد الموردين
            $.ajax({
                url: "{{ route('admin.suppliers.getSuppliersCount') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث القيمة
                    $('#suppliersCount').text(data.count);
                },
                error: function(error) {
                    console.error(' فشل جلب عدد الموردين :', error);
                }
            });


            //عدد المنتجات
            $.ajax({
                url: "{{ route('admin.products.getProductsCount') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث القيمة
                    $('#productsCount').text(data.count);
                },
                error: function(error) {
                    console.error(' فشل جلب عدد المنتجات :', error);
                }
            });


            //عدد المتاجر
            $.ajax({
                url: "{{ route('admin.dshboard.getstoreCount') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث القيمة
                    $('#storeCount').text(data.count);
                },
                error: function(error) {
                    console.error(' فشل جلب عدد المتاجر :', error);
                }
            });



            function initializeBalance() {
                // افتراضياً، قم بتشغيل الدالة عندما يتم تحميل الصفحة
                fetchData('thisYear');


                // استمع لحدث النقر على الروابط وقم بتشغيل الدالة المناسبة
                $('#todayBalance').click(function() {
                    fetchData('today');
                    $('#balanceDate').text('| اليوم');
                });

                $('#thisMonthBalance').click(function() {
                    fetchData('thisMonth');
                    $('#balanceDate').text('| هذا الشهر')
                });

                $('#thisYearBalance').click(function() {
                    fetchData('thisYear');
                    $('#balanceDate').text('| هذا العام')
                });

                $('#allBalance').click(function() {
                    fetchData('all');
                    $('#balanceDate').text('| الكل')

                });

                // دالة لجلب البيانات باستخدام AJAX
                function fetchData(timeframe) {
                    var url = "{{ route('admin.suppliers.getSuppliersTotalBalance') }}?timeframe=" + timeframe;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var total_balance_value = data.total_balance;
                            $("#totalBalanceCount").html(total_balance_value +
                                '<span style="font-size: small ;"> ري</span>');
                           // $('#totalBalanceCount').text('$' + data.total_balance);
                        },
                        error: function(error) {
                            console.error(' فشل في جلب  المديونية :', error);
                        }
                    });
                }
            }

            // استدعاء دالة المديونية
            initializeBalance();

            //المبيعات
            // $.ajax({
            //     url: "{{ route('admin.order.getTotalPaidOrdersAmount') }}",
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(data) {
            //         // تحديث القيمة
            //         $('#totalSales').text('$' + data.total_paid_amount);
            //     },
            //     error: function(error) {
            //         console.error(' فشل جلب المبيعات :', error);
            //     }
            // });

            //المبيعات
            function initializeSales() {
                // افتراضياً، قم بتشغيل الدالة عندما يتم تحميل الصفحة
                fetchData('thisMonth');


                // استمع لحدث النقر على الروابط وقم بتشغيل الدالة المناسبة
                $('#todaySales').click(function() {
                    fetchData('today');
                    $('#salesDate').text('| اليوم');
                });

                $('#thisMonthSales').click(function() {
                    fetchData('thisMonth');
                    $('#salesDate').text('| هذا الشهر')
                });

                $('#thisYearSales').click(function() {
                    fetchData('thisYear');
                    $('#salesDate').text('| هذا العام')
                });

                $('#AllSales').click(function() {
                    fetchData('all');
                    $('#salesDate').text('| الكل')

                });

                // دالة لجلب البيانات باستخدام AJAX
                function fetchData(timeframe) {
                    var url = "{{ route('admin.order.getTotalPaidOrdersAmount') }}?timeframe=" + timeframe;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var total_paid_amount = data.total_paid_amount;
                            $("#totalSales").html(total_paid_amount +
                                '<span style="font-size: small ;"> ري</span>');
                          //  $('#totalSales').text('$' + data.total_paid_amount);
                        },
                        error: function(error) {
                            console.error('Failed to fetch data:', error);
                        }
                    });
                }
            }

            // استدعاء دالة المبيعات
            initializeSales();



            var chartTrafficOptions = {
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    top: '5%',
                    left: 'center'
                },
                series: [{
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: '18',
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: [{
                            value: 0,
                            name: 'المبيعات',
                            itemStyle: {
                                color: '#3498db' // لون المبيعات
                            }
                        },
                        {
                            value: 0,
                            name: 'المديونية',
                            itemStyle: {
                                color: '#FF0000' // لون المديونية
                            }
                        },
                    ]
                }]
            };

            // إنشاء كائن ECharts باستخدام الخيارات
            var chartTraffic = echarts.init(document.querySelector('#trafficChart'));
            chartTraffic.setOption(chartTrafficOptions);

            //شارت المديونية VS المبيعات
            $.ajax({
                url: "{{ route('admin.dshboard.calculateChartTrafData') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث قيمة واحدة داخل المصفوفة في series
                    chartTrafficOptions.series[0].data[0].value = data.sales;

                    chartTrafficOptions.series[0].data[1].value = data.debts;

                    // استخدام setOption لتحديث الرسم البياني
                    chartTraffic.setOption(chartTrafficOptions);

                },
                error: function(error) {
                    console.error(' فشل جلب المبيعات :', error);
                }
            });







            $('#lastOrdersTable').DataTable({
                ajax: {
                    url: "{{ route('admin.order.getOrders') }}",
                    type: 'GET',
                    dataType: 'json',
                    dataSrc: ''
                },

                "autoWidth": false,
                "lengthMenu": [10, 5], // الخيارات المتاحة للمستخدم
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],
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
                        data: 'store_name',
                        title: 'المتجر'
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

            $('#lowQuantityProducts').DataTable({
                ajax: {
                    url: "{{ route('admin.products.getLowQuantityProducts') }}",
                    type: 'GET',
                    dataType: 'json',
                    dataSrc: ''
                },

                "autoWidth": false,
                "lengthMenu": [10, 5], // الخيارات المتاحة للمستخدم
                //إمكانية تحريك الاعمدة
                colReorder: true,
                responsive: true,
                order: [
                    [0, "desc"]
                ],
                //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                columnDefs: [{
                    targets: '_all', //كل الحقول
                    className: 'dt-right' //الاتجاه
                }],
                columns: [{
                        data: 'id',
                        title: 'ID'
                    },
                    {
                        data: 'image',
                        title: 'صورة',
                        render: function(data, type, full, meta) {
                            return '<a href="../../Products_img/' + data +
                                '" data-lightbox="product-image" data-title="Product Image">' +
                                '<img src="../../Products_img/' + data +
                                '" alt="Product Image" width="50" height="50">' +
                                '</a>';
                        }
                    },
                    {
                        data: 'name',
                        title: 'المنتج'
                    },
                    {
                        data: 'quantity',
                        title: 'الكمية'
                    },
                    {
                        data: 'barcode',
                        title: 'الباركود',
                    },
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json" // تحميل ملف اللغة العربية
                }
            });

            var options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                        name: '( مبلغ البيع )',
                        data: []
                    },
                    {
                        name: '( مبلغ الطلب )',
                        data: []
                    }
                ],
                markers: {
                    size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                fill: {
                    type: 'gradient',
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
            var chartReport = new ApexCharts(document.querySelector('#reportsChart'), options);

            // جلب البيانات عبر AJAX
            $.ajax({
                url: "{{ route('admin.dshboard.getChartData') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // تحديث البيانات في الـ chart
                    chartReport.updateSeries([{
                            data: data.salesData,
                            name: '( مبلغ البيع )'
                        },
                        {
                            data: data.ordersData,
                            name: '( مبلغ الطلب )'
                        }
                    ]);
                    chartReport.updateOptions({
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
            chartReport.render();

        });
    </script>
@endsection
