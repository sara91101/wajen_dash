<!DOCTYPE html>
<html lang="ar">

    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>نظام التحكم بالأنظمة المتعددة</title>

    <link rel="stylesheet" href="/styles/typicons.css">
    <link rel="stylesheet" href="/styles/vendor.bundle.base.css">

    <link rel="stylesheet" href="/css/chartist.min.css">

    <link rel="stylesheet" href="/styles/materialdesignicons.min.css"/>
    @if (Session::get('mode') == "light")
        <link rel="stylesheet" href="/styles/style.css">
    @else
        <link rel="stylesheet" href="/css/dark.css">
    @endif
    {{--  <link rel="stylesheet" href="/css/quill.css">  --}}
    <link href="/kufi/kufi.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/typicons.css">

    <link rel="stylesheet" href="/css/morris.css">
    <link rel="shortcut icon" href="/imgs/logo.jpeg" />

    <!-- Main Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

        <!-- Theme included stylesheets -->
        <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet"
        />
        <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.bubble.css"
        rel="stylesheet"
        />

        <!-- Core build with no theme, formatting, non-essential modules -->
        <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.core.css"
        rel="stylesheet"
        />
        <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.core.js"></script>

        <style>
        *{
        font-family: "Droid Arabic Kufi";
        }
        .toast-center-center {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: right !important;
            direction: rtl !important;
        }
    </style>
    </head>

    <body>
        <div class="container-scroller">

            <div class="horizontal-menu">
                <nav class="p-0 navbar top-navbar col-lg-12 col-12">
                    <div class="container">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="javascript:;"><img src="/imgs/logo.jpeg" alt="logo"/></a>
                    </div>
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                        <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="/imgs/user.png" alt="profile"/>
                            <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout text-primary"></i>
                                    تسجيل الخروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </li>
                        </ul>
                        <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-date dropdown">
                            <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
                            <h6 class="mb-0 date">Today : {{ date("M d") }}</h6>
                            <i class="typcn typcn-calendar"></i>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link d-flex justify-content-center align-items-center" href="/changeMode">
                            <i class="mdi mdi-theme-light-dark"></i>
                            </a>
                        </li> -->
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <span class="typcn typcn-th-menu"></span>
                        </button>
                    </div>
                    </div>
                </nav>
            </div>
        

        
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <div class="content-wrapper">


                
                <div class="content-wrapper d-flex align-items-center auth px-0">

          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">

                @if(isset($verification_message))
                    <div class="alert alert-danger text-right" align="right">{{ $verification_message }}</div>
                @endif
              <div class="auth-form-transparent text-start py-5 px-4 px-sm-5">
                        <form class="pt-3" action="/checkVerificationCode" method="post">
                            @csrf
                            <div class="form-group text-right" align="right">
                                <label class="text-right">رمز التحقق</label>
                                <input type="text" name="code" inputmode="numeric" class="form-control form-control-lg" pattern="\d{4}" maxlength="4" placeholder="4 digits" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-medium auth-form-btn">إرسال</button>
                            </div>
                            <div class="my-2 d-flex justify-content-center">
                                <a href="/sendOtpMessage?resend=1" class="auth-link text-black">إعادة إرسال رمز التحقق</a>
                            </div>
                        </form>
                    </div></div></div></div></div>
                    <br><br><br>
                    <footer class="footer">
                        <div class="d-flex justify-content-between">
                            <span class="text-center text-muted d-block text-sm-left d-sm-inline-block">Copyright © 2023 <a href="https://dash.wajen.net/" class="text-muted" target="_blank">Wajen</a>. All rights reserved.</span>
                        </div>
                    </footer>
                </div>
            </div>
        <script src="/js/vendor.bundle.base.js"></script>
        <script src="/js/tinymce.min.js"></script>
        <script src="/js/loader.js"></script>
        <script src="/js/Chart.min.js"></script>
        <script src="/js/off-canvas.js"></script>
        <script src="/js/hoverable-collapse.js"></script>
        <script src="/js/template.js"></script>
        <script src="/js/settings.js"></script>
        <script src="/js/todolist.js"></script>
        <script src="/js/dashboard.js"></script>
        <script src="/js/todolist.js"></script>
        <script src="/js/raphael.min.js"></script>
        <script src="/js/morris.min.js"></script>
        <script src="/js/morris.js"></script>
        <script src="/js/google-charts.js"></script>
        <script src="/js/chartist.min.js"></script>
        <script src="/js/chartist.js"></script>
        <script src="/js/raphael-2.1.4.min.js"></script>
        <script src="/js/justgage.js"></script>
        <script src="/js/just-gage.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
        <script src="/js/tinymce.min.js"></script>
        <script src="/js/editorDemo.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/bootstrap-maxlength.min.js"></script>
        <script src="/js/form-validation.js"></script>
        <script src="/js/bt-maxLength.js"></script>
    </body>

</html>
