
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
  <link rel="stylesheet" href="/css/quill.css">
  <link href="/kufi/kufi.css" rel="stylesheet">

  <link rel="stylesheet" href="/css/morris.css">
  <link rel="shortcut icon" href="/imgs/logo.jpeg" />

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
   <script src="/js/sweetAlert.js"></script>
    <script>
        function destroyItem(page,itemId)
        {
            swal({
                title: 'تحذير',
                text: "هل أنت متأكد من الحذف؟",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
            actions: 'vertical-buttons',
            cancelButton: 'top-margin'
            },
                buttons: {
                cancel: {
                    text: "لا",
                    value: null,
                    visible: true,
                    className: "btn btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "نعم",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
                }
            }).then(okay => {
            if (okay) {
                window.location = "/"+page+"/"+itemId;}
                });
        }
    </script>

</head>

<body>

    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header align-self-center">
                <h3 align="center" class="modal-title text-primary-purple"><b> تغيير كلمة المرور</b></h3>
            </div>
            <form method="POST" action="/changePassword">
                @csrf
                <div class="modal-body text-right font-weight-bold" dir="rtl">
                    <div class="form-group">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                             كلمة المرور الجديدة
                        </label>
                        <input type="password" name="password" class="form-control text-right" required>
                    </div>
                    {{--  <div class="form-group">
                        <label for="exampleInputUsername1" class="text-primary-purple">
                            <i class="mdi mdi-star text-danger"></i>
                            تأكيد كلمة المرور</label>
                        <input type="password" name="confirm" class="form-control text-right">
                    </div>  --}}
                </div>
                <div class="modal-footer justify-content-center" align="center">
                    <input type="submit" value="تأكيد" class="btn  my-btn btn-lg btn-primary">
                </div>
            </form>
          </div>
        </div>
    </div>


@if(Session("NoAccess") > 0)
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options=
        {
            positionClass: "toast-center-center"
        }
        toastr.error("{!! Session::get('NoAccess') !!}","عٌذراً");
        sessionStorage.clear();
    </script>
@endif

@if(Session("Notify") > 0)
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options=
        {
            positionClass: "toast-center-center"
        }
        toastr.warning("{!! Session::get('Notify') !!}","عٌذراً");
        sessionStorage.clear();
    </script>
@endif


@if (Session::has('Message'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options=
    {
        positionClass: "toast-center-center"
    }
    toastr.success("{!! Session::get('Message') !!}","نجاح");
    sessionStorage.clear();
    </script>
@endif
  <div class="container-scroller">

    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="/home"><img src="/imgs/logo.jpeg" alt="logo"/></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-2">
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                  <img src="/imgs/user.png" alt="profile"/>
                  <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#changePassword" data-whatever="@fat">
                    <i class="mdi mdi-account-key text-primary"></i>
                    تغيير كلمة المرور
                  </a>
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
                  <h6 class="date mb-0">Today : {{ date("M d") }}</h6>
                  <i class="typcn typcn-calendar"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex justify-content-center align-items-center" href="/changeMode">
                  <i class="mdi mdi-theme-light-dark"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="typcn typcn-cog-outline mx-0"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <p class="font-weight-normal float-right dropdown-header" style="text-align: right !important">الإعدادات</p>
                  <a class="dropdown-item preview-item" href="/info">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject  font-weight-normal text-right">
                        من نحن
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="towns">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-home-map-marker"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        المُدُن
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/governorates">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-home-modern"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        المٌحافظات
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/activities">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-coffee"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        أنواع النشاط
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/units">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-speedometer"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        وحدات القياس
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/userSessions">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-wheelchair-accessibility"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        الجلسات النشطة
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/services">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-database"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                         الخدمات
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/faqs">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-information"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                         الأسئلة المتكررة
                      </h6>
                    </div>
                  </a>
                  <!--a class="dropdown-item preview-item" href="/userTypes">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-account-key"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        أنواع المستخدمين
                      </h6>
                    </div>
                  </a-->
                  <a class="dropdown-item preview-item" href="/levels">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-key"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        الصلاحيات
                      </h6>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" href="/users">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-account-multiple-plus"></i>
                    </div>
                    <div class="preview-item-content flex-grow" align="right">
                      <h6 class="preview-subject font-weight-normal">
                        المستخدمين
                      </h6>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="typcn typcn-th-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar" dir="rtl">
        <div class="container">
          <ul class="nav page-navigation">

            <li class="nav-item">
              <a class="nav-link" href="{{ url('/home') }}">
                <i class="mdi mdi-desktop-mac menu-icon"></i>
                &nbsp;&nbsp;
                <span class="menu-title font-weight-bold">الرئيسية</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('/systems') }}">
                <i class="typcn typcn-th-menu menu-icon"></i>
                &nbsp;&nbsp;
                <span class="menu-title font-weight-bold">الأنظمة</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="mdi mdi-package menu-icon"></i>
                &nbsp;
                <span class="menu-title font-weight-bold">باقات الإشتراك</span>&nbsp;
                <i class="menu-arrow"></i>
                </a>
                <div class="submenu text-right" dir="rtl">
                    <ul class="submenu-item">
                      <li class="nav-item"><a class="nav-link" href="/packages">الباقات </a></li>
                      <li class="nav-item"><a class="nav-link" href="/majors">القائمة الرئيسية</a></li>
                      <li class="nav-item"><a class="nav-link" href="/minors">القوائم الفرعية</a></li>
                      <li class="nav-item"><a class="nav-link" href="/properties"> الخصائص</a></li>
                    </ul>
                  </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-human-male-female menu-icon"></i>
                  &nbsp;
                  <span class="menu-title font-weight-bold">المشتركين</span>&nbsp;
                  <i class="menu-arrow"></i>
                  </a>
                  <div class="submenu text-right" dir="rtl">
                      <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="/customers">قائمة المشتركين </a></li>
                        <li class="nav-item"><a class="nav-link" href="/casheirs">طلبات تفعيل الكاشير </a></li>
                        <li class="nav-item"><a class="nav-link" href="/archiveCustomers">  الأرشيف </a></li>
                      </ul>
                  </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/questions') }}">
                  <i class="mdi mdi-help menu-icon"></i>
                  &nbsp;&nbsp;
                  <span class="menu-title font-weight-bold">الأسئلة والإستفسارات</span>
                </a>
              </li>



            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="mdi mdi-chart-bar menu-icon"></i>&nbsp;
                <span class="menu-title font-weight-bold">التقارير</span>&nbsp;
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu text-right" dir="rtl">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="/customer_systems_report">إحصائية المشتركين بالنظام</a></li>
                  <li class="nav-item"><a class="nav-link" href="/customer_towns_report">إحصائية المشتركين بالمٌدٌن</a></li>
                  <li class="nav-item"><a class="nav-link" href="/customer_governorates_report">إحصائية المشتركين بالمحافظات</a></li>
                  <li class="nav-item"><a class="nav-link" href="/customer_packages_report">إحصائية المشتركين بالباقات</a></li>
                  <li class="nav-item"><a class="nav-link" href="/customer_substraction_report"> إحصائية المشتركين بالإشتراك</a></li>
                </ul>
              </div>
            </li>


          </ul>
        </div>
      </nav>
    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
            @yield("content")

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-flex justify-content-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2023 <a href="https://dash.wajen.net/" class="text-muted" target="_blank">Wajen</a>. All rights reserved.</span>
            </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="/js/loader.js"></script>
  <script src="/js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="/js/off-canvas.js"></script>
  <script src="/js/hoverable-collapse.js"></script>
  <script src="/js/template.js"></script>
  <script src="/js/settings.js"></script>
  <script src="/js/todolist.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="/js/dashboard.js"></script>
  <script src="/js/todolist.js"></script>
  <!-- End custom js for this page-->

  <script src="/js/raphael.min.js"></script>
  <script src="/js/morris.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="/js/morris.js"></script>

  <script src="/js/google-charts.js"></script>

  <script src="/js/chartist.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="/js/chartist.js"></script>

  <script src="/js/raphael-2.1.4.min.js"></script>
  <script src="/js/justgage.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="/js/just-gage.js"></script>

  <script src="/js/quill.js"></script>
  <script src="/js/editorDemo.js"></script>

  <script src="/js/jquery.validate.min.js"></script>
  <script src="/js/bootstrap-maxlength.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="/js/form-validation.js"></script>
  <script src="/js/bt-maxLength.js"></script>
</body>

</html>
