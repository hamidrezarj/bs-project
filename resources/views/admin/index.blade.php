@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection()

@section('title', 'ادمین')

@section('profile')
    <div class="profile-part mb-5">
        <div class="user-profile-img rounded d-flex justify-content-center align-items-center">
            <i class="fa fa-user"></i>
        </div>
        <h6 id="user_fullName"></h6>
        <div class="profile-button-parent">
                <div class="d-flex align-items-center">
                    <button id="user_data" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="اطلاعات کاربر" class="btn btn-sm btn-default"><i class="fa fa-user"></i></button>
                    <button id="edit_profile" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ویرایش پروفایل" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></button>
                    <button id="reset_pass" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="تغییر رمز عبور" class="btn btn-sm btn-default"><i class="fas fa-key"></i></button>
                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="خروج" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i></button></a>
                </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-action-parent justify-content-center d-flex">
        <button id="add_supporter" class="btn add-self-design btn-sm d-flex align-items-center mx-auto">ثبت پشتیبان جدید <i class="fa fa-plus ms-1"></i></button>
        <button id="complete_report" class="btn add-self-design btn-sm d-flex align-items-center mx-auto">گزارش خلاصه عملکرد مرکز <i class="fa fa-file ms-1"></i></button>
    </div>
    <hr>
    <div class="table-parent">
        <table id="admin_table" class="table table-striped table-bordered table-self-style" style="width: 100%;">
            <thead>
                <tr>
                    <th class="filter-text text-center">ردیف</th>
                    <th class="filter-text text-center">کد یکتا</th>
                    <th class="filter-text text-center">نام</th>
                    <th class="filter-text text-center">نام خانوادگی </th>
                    <th class="filter-text text-center">ایمیل</th>
                    <th class="filter-text text-center">کدملی</th>
                    <th class="filter-text text-center">شماره</th>
                    <th class="filter-text text-center">نام دانشکده</th>
                    <th class="filter-date text-center">تاریخ ایجاد حساب</th>
                    <th class="filter-none text-center">عملیات</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- add supporter --}}
    <div class="modal fade" id="add_supporter_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="add_supporter_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">ثبت پشتیبان</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="add_supporter_first_name" class="form-label">نام</label>
                                <input id="add_supporter_first_name" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="add_supporter_last_name" class="form-label">نام خانوادگی</label>
                                <input id="add_supporter_last_name" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="add_supporter_national_code" class="form-label">کدملی</label>
                                <input id="add_supporter_national_code" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="add_supporter_phone_number" class="form-label">شماره موبایل</label>
                                <input id="add_supporter_phone_number" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="add_supporter_faculty" class="form-label">دانشکده</label>
                                <input id="add_supporter_faculty" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="add_supporter_email" class="form-label">ایمیل</label>
                                <input id="add_supporter_email" type="email" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div style="width: 47%">
                                <label for="add_supporter_pasword" class="form-label label-input-login">رمز عبور</label>
                                <div type="text" class="input-group rounded">
                                    <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                    <input type="password" id="add_supporter_password" tabindex="1" name="password" required
                                        class="form-control rounded-end px-4 pass-input input-cleaner" autocomplete="off"
                                        data-v-min-length="8">
                                    <span class="input-group-text eye-pass"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div style="width: 47%">
                                <label for="add_supporter_password_confirmation" class="form-label label-input-login">تکرار رمز عبور</label>
                                <div type="text" class="input-group rounded">
                                    <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                    <input type="password" tabindex="1" name="password_confirmation" required
                                        class="form-control rounded-end px-4 pass-input input-cleaner" id="add_supporter_password_confirmation" autocomplete="off"
                                        data-v-equal="#add_supporter_password" data-v-min-length="8">
                                    <span class="input-group-text eye-pass"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="add_supporter_form" id="add_supporter_cta" type="submit" data-row-id="" class="btn btn-success">ثبت</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end add supporter --}}

    {{-- edit supporter --}}
    <div class="modal fade" id="edit_supporter_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="edit_supporter_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">ویرایش پشتیبان</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="edit_supporter_first_name" class="form-label">نام</label>
                                <input id="edit_supporter_first_name" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="edit_supporter_last_name" class="form-label">نام خانوادگی</label>
                                <input id="edit_supporter_last_name" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="edit_supporter_national_code" class="form-label">کدملی</label>
                                <input id="edit_supporter_national_code" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="edit_supporter_phone_number" class="form-label">شماره موبایل</label>
                                <input id="edit_supporter_phone_number" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="edit_supporter_faculty" class="form-label">دانشکده</label>
                                <input id="edit_supporter_faculty" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="edit_supporter_email" class="form-label">ایمیل</label>
                                <input id="edit_supporter_email" type="email" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div style="width: 47%">
                                <label for="edit_supporter_pasword" class="form-label label-input-login">رمز عبور</label>
                                <div type="text" class="input-group rounded">
                                    <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                    <input type="password" id="edit_supporter_password" tabindex="1" name="password"
                                        class="form-control rounded-end px-4 pass-input input-cleaner" autocomplete="off"
                                        data-v-min-length="8">
                                    <span class="input-group-text eye-pass"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div style="width: 47%">
                                <label for="edit_supporter_password_confirmation" class="form-label label-input-login">تکرار رمز عبور</label>
                                <div type="text" class="input-group rounded">
                                    <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                    <input type="password" tabindex="1" name="password_confirmation"
                                        class="form-control rounded-end px-4 pass-input input-cleaner" id="edit_supporter_password_confirmation" autocomplete="off"
                                        data-v-equal="#edit_supporter_password" data-v-min-length="8">
                                    <span class="input-group-text eye-pass"><i class="fa fa-eye-slash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="edit_supporter_form" id="edit_supporter_cta" type="submit" class="btn btn-success">ویرایش</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end edit supporter --}}

    {{-- performance report supporter --}}
    <div class="modal fade" id="supporter_performance_report" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="supporter_report_performance_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">گزارش خلاصه عملکرد پشتیبان</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="supporter_performance_from_date" class="form-label">از تاریخ</label>
                                <input id="supporter_performance_from_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="supporter_performance_to_date" class="form-label">تا تاریخ</label>
                                <input id="supporter_performance_to_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="supporter_report_performance_form" id="supporter_report_performance" type="submit" data-row-id="" class="btn btn-success">دریافت گزارش</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end  performance report supporter --}}

    {{-- rate report supporter --}}
    <div class="modal fade" id="supporter_rate_report" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="supporter_report_rate_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">گزارش درصد پاسخگویی پشتیبان</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="supporter_rate_from_date" class="form-label">از تاریخ</label>
                                <input id="supporter_rate_from_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="supporter_rate_to_date" class="form-label">تا تاریخ</label>
                                <input id="supporter_rate_to_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="supporter_report_rate_form" id="supporter_report_rate" type="submit" data-row-id="" class="btn btn-success">دریافت گزارش</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end  rate report supporter --}}

    {{-- complete report --}}
    <div class="modal fade" id="complete_report_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="complete_report_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">گزارش رای دهی به پشتیبان</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-5 my-2">
                                <label for="complete_report_from_date" class="form-label">از تاریخ</label>
                                <input id="complete_report_from_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="complete_report_to_date" class="form-label">تا تاریخ</label>
                                <input id="complete_report_to_date" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="complete_report_form" type="submit" data-row-id="" class="btn btn-success">دریافت گزارش</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end  complete report --}}
@endsection
@section('footer')
    <div class="footer d-flex align-items-center justify-content-between">
        <div class="university-name ms-4">سامانه ثبت تیکت دانشگاه شهید بهشتی</div>
        <div class="me-4">تاریخ: ( <span class="date-place"></span> )</div>
    </div>
@endsection()
@section('script')
    <script type = "module" src="{{ asset('js/admin.js') }}"></script>
@endsection()
