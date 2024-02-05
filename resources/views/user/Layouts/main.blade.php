@extends('user.layouts.app')

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @yield('js')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- mmmmmmmm --}}
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> @yield('pageTitle')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href={{ asset('Admin/IMG/favicon.png') }} rel="icon">
    <link href={{ asset('Admin/IMG/apple-touch-icon.png') }} rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />

    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />

    <!-- Vendor CSS Files -->
    <link href={{ asset('Admin/vendor/bootstrap/css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/bootstrap-icons/bootstrap-icons.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/boxicons/css/boxicons.min.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/quill/quill.snow.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/quill/quill.bubble.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/remixicon/remixicon.css') }} rel="stylesheet">
    <link href={{ asset('Admin/vendor/simple-datatables/style.css') }} rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DataTables CSS Files add by ibrahim -->
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.css" rel="stylesheet">

    @yield('css')

    <!-- Template Main CSS File -->
    <link href={{ asset('Admin/CSS/style.css') }} rel="stylesheet">

</head>

<body dir="rtl">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src={{ asset('Admin/IMG/logo.png') }} alt="">
                <span class="d-none d-lg-block">المخازن الالكترونية</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav me-auto">
            <ul class="d-flex align-items-center">




                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                        <span class=" dropdown-toggle pe-2"><span id="balance_main"></span>رس</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end d profile">
                        <li class="dropdown-header">
                            <h6>المحفظة</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.transfers') }}">
                                <i class="bi bi-person"></i>
                                <span>الحوالات</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.transfers.create') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>ايداع للمحفظة</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ Route('user.wallets.operation') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>عمليات المحفظة</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class=" dropdown-toggle pe-2">{{ Auth::user()->store_name }} </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end  profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav " id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="/Dshboard">
                    <i class="bi bi-grid"></i>
                    <span>لوحة التحكم</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ Route('user.products.catalogue') }}">
                    <i class="bi bi-grid"></i>
                    <span>كتالوج المنتجات</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ Route('seller.products') }}">
                    <i class="bi bi-grid"></i>
                    <span>قائمة منتجاتي</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ Route('user.wallets.operation') }}">
                    <i class="bi bi-grid"></i>
                    <span>المحفظة</span>
                </a>
            </li><!-- End Register Page Nav -->







            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Products-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text "></i><span>المنتجات</span><i class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.products') }}">
                            <i class="bi bi-circle"></i><span>إدارة المنتجات</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->



            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Transfers-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>الحوالات</span><i class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Transfers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.transfers') }}">
                            <i class="bi bi-circle"></i><span>ادارة الحوالات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.transfer.info') }}">
                            <i class="bi bi-circle"></i><span>معلومات التحويل</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <a class="nav-link collapsed" href="{{ Route('user.order') }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>الطلبات</span>
            </a>
            <!-- End Order Nav -->






            <li class="nav-item">
                <a class="nav-link collapsed" href="/user/profile">
                    <i class="bi bi-person"></i>
                    <span>الحساب التعريفي</span>
                </a>
            </li><!-- End Profile Page Nav -->
            <li class="nav-item ">
                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                </a> --}}



                <a class="nav-link collapsed" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-in-right"></i>

                    خروج
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </li>


        </ul>


    </aside><!-- End Sidebar-->

    @yield('Content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        {{-- <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div> --}}
        {{-- <div class="credits"> --}}
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
        {{-- </div> --}}
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src={{ asset('Admin/vendor/apexcharts/apexcharts.min.js') }}></script>
    <script src={{ asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('Admin/vendor/chart.js/chart.umd.js') }}></script>
    <script src={{ asset('Admin/vendor/echarts/echarts.min.js') }}></script>
    <script src={{ asset('Admin/vendor/quill/quill.min.js') }}></script>
    <script src={{ asset('Admin/vendor/simple-datatables/simple-datatables.js') }}></script>
    <script src={{ asset('Admin/vendor/tinymce/tinymce.min.js') }}></script>
    <script src={{ asset('Admin/vendor/php-email-form/validate.js') }}></script>
    <!-- DataTables Js Files add by ibrahim -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js">
    </script>
    <!-- تضمين مكتبة moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="text/javascript">
        $.ajax({
            type: 'get',
            url: "{{ route('user.wallet.getBalance') }}",
            async: false,
            success: function(data) {
                // استخدام قيمة $wallet الفعلية التي تم استرجاعها من الخادم
                var balanceValue = data.balance;
                $("#balance_main").text(balanceValue);
            },
            error: function(reject) {
                console.error('Error loading :', reject);
            }
        });
    </script>
    @yield('js')


    <!-- Template Main JS File -->
    <script src={{ asset('Admin/JS/main.js') }}></script>


</body>

</html>