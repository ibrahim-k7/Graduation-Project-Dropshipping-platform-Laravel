<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('Admin/IMG/favicon.png') }}" rel="icon">
    <link href="{{ asset('Admin/IMG/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link href="{{ asset('Admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.css"
        rel="stylesheet">
    @yield('css')
    <link href="{{ asset('User/CSS/style.css') }}" rel="stylesheet">
</head>

<body dir="rtl">

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-custom">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('Admin/IMG/logo.png') }}" alt="">
                    المخازن الالكترونية
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('انشاء حساب') }}</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <section id="hero" class="hero d-flex align-items-center">
        <div class="container">
            <h1>مرحبًا بك في منصة دروب شوبينج</h1>
            <h2>ابدأ رحلتك في عالم التجارة الإلكترونية</h2>
            <a href="{{ route('login') }}" class="btn-get-started scrollto">ابدأ الآن</a>
        </div>
    </section>

    <main id="main">

        <section id="why-us" class="why-us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="content">
                            <h3>لماذا تختار منصة دروب شوبينج؟</h3>
                            <ul>
                                <li>سهولة الاستخدام</li>
                                <li>لا تتطلب رأس مال كبير</li>
                                <li>مجموعة واسعة من المنتجات</li>
                                <li>دعم فني متميز</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="icon-boxes d-flex flex-column justify-content-center">
                            <div class="row">
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-receipt"></i>
                                        <h4>سهولة الطلب</h4>
                                        <p>يمكنك طلب المنتجات بسهولة من خلال المنصة.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-cube"></i>
                                        <h4>مجموعة واسعة من المنتجات</h4>
                                        <p>تُقدم المنصة مجموعة واسعة من المنتجات لتلبية احتياجاتك.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box mt-4 mt-xl-0">
                                        <i class="bx bx-support"></i>
                                        <h4>دعم فني متميز</h4>
                                        <p>يُقدم فريق الدعم الفني المساعدة لك في أي وقت.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="cta">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3>ابدأ رحلتك في عالم التجارة الإلكترونية</h3>
                        <p>انضم إلى منصة دروب شوبينج وابدأ بيع المنتجات عبر الإنترنت.</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a href="{{ route('login') }}" class="btn-get-started scrollto">ابدأ الآن</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>المخازن الالكترونية</h3>
                        <p>
                            <br>
                            <strong>البريد الإلكتروني:</strong> info@example.com
                        </p>
                    </div>
                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>الروابط السريعة</h4>
                        <ul>
                            <li><a href="#">الرئيسية</a></li>
                            <li><a href="#">من نحن</a></li>
                            <li><a href="#">المنتجات</a></li>
                            <li><a href="#">الخدمات</a></li>
                            <li><a href="#">اتصل بنا</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>الخدمات</h4>
                        <ul>
                            <li><a href="#">دروب شوبينج</a></li>
                            <li><a href="#">التسويق الإلكتروني</a></li>
                            <li><a href="#">تصميم المواقع الإلكترونية</a></li>
                            <li><a href="#">تطوير البرمجيات</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>اشترك في نشرتنا البريدية</h4>
                        <p>احصل على آخر العروض والخصومات من خلال الاشتراك في نشرتنا البريدية.</p>
                        <form action="" method="post">
                            <input type="email" name="email">
                            <input type="submit" value="اشترك">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>المخازن الالكترونية</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">Ibrahim</a>
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Admin/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('Admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('Admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('Admin/JS/main.js') }}"></script>

</body>

</html>
