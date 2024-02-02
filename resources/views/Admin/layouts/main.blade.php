@extends('admin.layouts.app')
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
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
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

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
    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.css"
        rel="stylesheet">

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
                <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav me-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">

                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src={{ asset('Admin/IMG/messages-1.jpg') }} alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src={{ asset('Admin/IMG/messages-2.jpg') }} alt="" class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src={{ asset('Admin/IMG/messages-3.jpg') }} alt="" class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        {{-- <img src={{ asset('Admin/IMG/profile-img.jpg') }} alt="Profile" class="rounded-circle"> --}}
                        <span class="d-none d-md-block dropdown-toggle pe-2">{{ Auth::guard('admin')->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
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

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.dshboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/forms-validation">
                            <i class="bi bi-circle"></i><span>Form Validation</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Products-nav" data-bs-toggle="collapse"
                    href="#">
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
                <a class="nav-link collapsed" data-bs-target="#Categories-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-journal-text "></i><span>الفئات</span><i class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Categories-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.categories') }}">
                            <i class="bi bi-circle"></i><span>إدارة الفئات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.subCategories') }}">
                            <i class="bi bi-circle"></i><span>إدارة الفئات الفرعية</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Suppliers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-journal-text "></i><span>الموردين</span><i class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Suppliers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.suppliers') }}">
                            <i class="bi bi-circle"></i><span>إدارة الموردين</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.suppliers.create') }}">
                            <i class="bi bi-circle"></i><span>اضافة مورد جديد</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.suppliers.transactions') }}">
                            <i class="bi bi-circle"></i><span>عمليات الموردين</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.suppliers.transactions.create') }}">
                            <i class="bi bi-circle"></i><span>اضافة عملية جديدة لمورد</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#delivery-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>التوصيل</span><i
                        class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="delivery-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.delivery') }}">
                            <i class="bi bi-circle"></i><span>ادارة التوصيل</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.delivery.insert') }}">
                            <i class="bi bi-circle"></i><span>اضافة توصيل </span>
                        </a>
                    </li>

                </ul>
            </li><!-- End delivery Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#order-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>الطلبات</span><i
                        class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="order-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.order') }}">
                            <i class="bi bi-circle"></i><span>ادارة الطلبات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.order.details') }}">
                            <i class="bi bi-circle"></i><span>عرض تفاصيل الطلبات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.returned.order.details') }}">
                            <i class="bi bi-circle"></i><span>عرض الطلبات المسترجعة</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.sales') }}">
                            <i class="bi bi-circle"></i><span>المبيعات</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Order Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Wallet-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>المحافظ</span><i
                        class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Wallet-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ Route('admin.wallets') }}">
                            <i class="bi bi-circle"></i><span>إداره المحافظ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.wallets.operation') }}">
                            <i class="bi bi-circle"></i><span>عمليات المحافظ</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Transfers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>الحوالات</span><i
                        class="bi bi-chevron-down me-auto"></i>
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

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Purchases-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Purchases</span><i
                        class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="Purchases-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.purchase.index') }}">
                            <i class="bi bi-circle"></i><span>Purchases</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.purchase.create') }}">
                            <i class="bi bi-circle"></i><span>Insert New Purchases</span>
                        </a>
                    </li>

                    <li>
                        <a href=>
                            <i class="bi bi-circle"></i><span>Purchase Details</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.purchase.return') }}">
                            <i class="bi bi-circle"></i><span>Return Purchases</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->




            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Data Tables</span><i
                        class="bi bi-chevron-down me-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/wallet">
                            <i class="bi bi-circle"></i><span>Wallets</span>
                        </a>
                    </li>
                    <li>
                        <a href="/simple">
                            <i class="bi bi-circle"></i><span>Simple</span>
                        </a>
                    </li>
                    <li>
                        <a href="tables-data.html">
                            <i class="bi bi-circle"></i><span>Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="/Purchases">
                            <i class="bi bi-circle"></i><span>Purchases</span>
                        </a>
                    </li>
                </ul>
            <li class="nav-heading">Pages</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin/user-information">
                    <i class="bi bi-person"></i>
                    <span>معلومات المتاجر </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin/profile">
                    <i class="bi bi-person"></i>
                    <span>الحساب التعريفي</span>
                </a>
            </li><!-- End Profile Page Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin/dshboard/register">
                    <i class="bi bi-card-list"></i>
                    <span>انشاء حساب</span>
                </a>
            </li><!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin/dshboard/login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>تسجيل الدخول</span>
                </a>
            </li><!-- End Login Page Nav -->
            <li class="nav-item ">
                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a> --}}


                <a class="nav-link collapsed" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
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
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        {{-- <div class="credits"> --}}
            {{-- <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
        {{-- </div> --}}
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src={{ asset('Admin/vendor/apexcharts/apexcharts.min.js') }}></script>
    {{-- <script src={{ asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script> --}}
    <script src={{ asset('Admin/vendor/chart.js/chart.umd.js') }}></script>
    <script src={{ asset('Admin/vendor/echarts/echarts.min.js') }}></script>
    <script src={{ asset('Admin/vendor/quill/quill.min.js') }}></script>
    <script src={{ asset('Admin/vendor/simple-datatables/simple-datatables.js') }}></script>
    <script src={{ asset('Admin/vendor/tinymce/tinymce.min.js') }}></script>
    <script src={{ asset('Admin/vendor/php-email-form/validate.js') }}></script>
    <!-- DataTables Js Files add by ibrahim -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js">
    </script>
    <!-- تضمين مكتبة moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    @yield('js')


    <!-- Template Main JS File -->
    <script src={{ asset('Admin/JS/main.js') }}></script>


</body>

</html>
