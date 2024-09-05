<!DOCTYPE html>
<html lang="ar">

    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>نظام التحكم بالأنظمة المتعددة</title>
    <!-- base:css -->
    <link rel="stylesheet" href="/styles/typicons.css">
    <link rel="stylesheet" href="/styles/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="/styles/vendor.bundle.base.css">

    <link href="/kufi/kufi.css" rel="stylesheet">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/dark.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/imgs/bill.jpeg" />

    <style>
        *{
           font-family: "Droid Arabic Kufi";
         }
       </style>

    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                    <div class="row flex-grow">
                        <div class="col-lg-6 d-flex align-items-center justify-content-center">
                            <div class="auth-form-transparent text-start p-3">
                                <div class="brand-logo" align="center">
                                    <img src="/imgs/bill.jpeg" alt="logo">
                                </div>
                                <h4 class="text-center">وﺟﻴﻦ ﻟﺘﻘﻨﻴﺔ اﻟﻤﻌﻠﻮﻣﺎت</h4>
                                <h6 class="font-weight-light text-center">نظام التحكم بالأنظمة المتعددة</h6>
                                <form class="pt-3" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group" align="right">
                                        <label>إسم المستخدم</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                            <i class="mdi mdi-account text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" class="form-control form-control-lg border-left-0">
                                        @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group" align="right">
                                        <label>كلمة المرور</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                            <i class="mdi mdi-key text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" class="form-control form-control-lg border-left-0">
                                        @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                تسجيل الدخول
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6 register-half-bg d-flex flex-row">
                            <p class="text-white font-weight-medium text-center flex-grow align-self-end" dir="rtl">جميع الحقوق محفوظة &copy; {{ date("Y") }}  وﺟﻴﻦ ﻟﺘﻘﻨﻴﺔ اﻟﻤﻌﻠﻮﻣﺎت.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
