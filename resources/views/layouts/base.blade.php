<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#082032">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/lib/fontiran.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/sweetalert.min.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/lib/mainstyles.css') }}">
    @yield('css')
    <title>@yield('title')</title>
</head>

<body>
    <!-- logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- end logout form -->
    <div class="loader-box d-flex align-items-center justify-content-center w-100 h-100 d-none">
        <div class="loader">
            <svg viewBox="0 0 120 120" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <circle class="load one" cx="60" cy="60" r="40" />
                <circle class="load two" cx="60" cy="60" r="40" />
                <circle class="load three" cx="60" cy="60" r="40" />
                <g>
                <circle class="point one" cx="45" cy="70" r="5" />
                <circle class="point two" cx="60" cy="70" r="5" />
                <circle class="point three" cx="75" cy="70" r="5" />
                </g>
            </svg>
        </div>
    </div>
    @yield('profile')
    <div class="modal fade" id="reset_pass_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title">تغییر رمز عبور</h6>
                <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body my-2">
                    <form class="needs-validation" id="change_pass_form" novalidate>
                        <label class="form-label label-input-login">رمز عبور فعلی</label>
                        <div type="text" class="input-group rounded">
                            <span class="input-group-text rounded-0 rounded-start"><i class="fa fa-key"></i></span>
                            <input id="password_last" type="password" tabindex="1" class="form-control rounded-0 border-start-0 px-4 input-cleaner pass-input"
                                data-v-min-length="8" autocomplete="off" name="password-last" required>
                            <span class="input-group-text rounded-0 rounded-end eye-pass"><i class="fa fa-eye-slash"></i></span>
                        </div>
                        <label class="form-label label-input-login">رمز عبور جدید</label>
                        <div type="text" class="input-group rounded">
                            <span class="input-group-text rounded-0 rounded-start"><i class="fa fa-key"></i></span>
                            <input id="pasword_new" type="password" tabindex="1" class="form-control rounded-0 border-start-0 px-4 input-cleaner pass-input"
                                data-v-min-length="8" autocomplete="off" name="password-new" required>
                            <span class="input-group-text rounded-0 rounded-end eye-pass"><i class="fa fa-eye-slash"></i></span>
                        </div>
                        <label class="form-label label-input-login">تکرار رمز عبور جدید</label>
                        <div type="text" class="input-group rounded">
                            <span class="input-group-text rounded-0 rounded-start"><i class="fa fa-key"></i></span>
                            <input id="password_confirmation" type="password" tabindex="1" class="form-control rounded-0 border-start-0 px-4 input-cleaner pass-input"
                                data-v-equal="#pasword_new" data-v-min-length="8" autocomplete="off" name="password-confirm" required>
                            <span class="input-group-text rounded-0 rounded-end eye-pass"><i class="fa fa-eye-slash"></i></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="change_pass_form" id="change_pass_cta" class="btn btn-success">ثبت</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_profile_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="modal-title">ویرایش اطلاعات کاربری</h6>
                <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body my-2">
                    <form class="needs-validation" id="edit_profile_form" novalidate>
                        <div class="input-parent">
                            <label for="first_name_ep" class="form-label fw-bolder mb-1">نام</label>
                            <input id="first_name_ep" type="text" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="first-name" required>
                        </div>
                        <div class="input-parent mt-2">
                            <label for="last_name_ep" class="form-label fw-bolder mb-1">نام خانوادگی</label>
                            <input id="last_name_ep" type="text" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="last-name" required>
                        </div>
                        <div class="input-parent mt-2">
                            <label for="email_ep" class="form-label fw-bolder mb-1">ایمیل</label>
                            <input id="email_ep" type="email" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="email" required>
                        </div>
                        <div class="input-parent mt-2">
                            <label for="national_code_ep" class="form-label fw-bolder mb-1">کدملی</label>
                            <input id="national_code_ep" type="text" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="national-code" required>
                        </div>
                        <div class="input-parent mt-2">
                            <label for="faculty_ep" class="form-label fw-bolder mb-1">دانشکده</label>
                            <input id="faculty_ep" type="text" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="faculty" required>
                        </div>
                        <div class="input-parent mt-2">
                            <label for="phone_number_ep" class="form-label fw-bolder mb-1">شماره موبایل</label>
                            <input id="phone_number_ep" type="text" tabindex="1" class="form-control px-4 input-cleaner"
                            autocomplete="off" name="phone-number" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="edit_profile_form" id="edit_profile_cta" type="submit" class="btn btn-success">ویرایش</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="user_data_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">مشخصات کاربری</h6>
                    <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body my-2">
                    <div class="my-2 d-flex align-items-center"><span class="user-title">نام کاربری: </span><span id="full_name" class="user-body ms-2"></span><hr class="col ms-2"></div>
                    <div class="my-2 d-flex align-items-center"><span class="user-title">کدملی: </span><span id="national_code" class="user-body ms-2"></span><hr class="col ms-2"></div>
                    <div class="my-2 d-flex align-items-center"><span class="user-title">تاریخ ثبت نام: </span><span id="created_at" class="user-body ms-2"></span><hr class="col ms-2"></div>
                    <div class="my-2 d-flex align-items-center"><span class="user-title">دانشکده: </span><span id="faculty" class="user-body ms-2"></span><hr class="col ms-2"></div>
                    <div class="my-2 d-flex align-items-center"><span class="user-title">ایمیل: </span><span id="email" class="user-body ms-2"></span><hr class="col ms-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid self-style">
        @yield('content')
    </div>
    @yield('footer')
    <script src="{{ asset('js/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/lib/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/lib/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('js/lib/moment-jalaali.js') }}"></script>
    <script src="{{ asset('js/lib/sweetalert2js.js') }}"></script>
    <script src="{{ asset('js/lib/jbvalidator.js') }}"></script>
    <script  type="module" src="{{ asset('js/lib/main.js') }}"></script>
    @yield('script')
</body>

</html>
