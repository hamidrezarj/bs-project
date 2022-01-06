@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/support.css') }}">
@endsection()

@section('title', 'کاربر')

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
                    <div class="form-check form-switch ms-2">
                        <input class="form-check-input" type="checkbox" id="activation" checked>
                        <label class="form-check-label" for="activation" style="color:#c78902f6;">شما فعال هستید</label>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-parent">
        <table id="support_table" class="table table-striped table-bordered table-self-style" style="width: 100%;">
            <thead>
                <tr>
                    <th class="filter-text text-center">ردیف</th>
                    <th class="filter-text text-center">کد تیکت</th>
                    <th class="filter-text text-center">کد کاربر</th>
                    <th class="filter-text text-center">نام کاربر</th>
                    <th class="filter-text text-center">نام خانوادگی کاربر</th>
                    <th class="filter-text text-center">کد درس</th>
                    <th class="filter-text text-center">نام درس</th>
                    <th class="filter-text text-center">شرح درخواست</th>
                    <th class="filter-select text-center" data-select-name='[" در انتظار پاسخ" , "پاسخ داده شده", "تکمیل شده" , "نا موفق" ]' data-select-value='[1,2,3,4]'>وضعیت</th>
                    <th class="filter-date text-center">تاریخ ثبت درخواست</th>
                    <th class="filter-date text-center">تاریخ انقضا تیکت</th>
                    <th class="filter-none text-center">عملیات</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="description_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">شرح درخواست</h6>
                <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
            </div>
                <div class="modal-body text-center my-2">
                    <p class="description-value"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ticket_answer_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body my-2">
                    <div class="d-flex justify-content-center align-items-center text-center">
                        <div class="col text-nowrap">کد کاربر: <span class="user-code fw-bolder ticket-data"></span></div>
                        <hr class="col">
                        <div class="col text-nowrap">کد تیکت: <span class="ticket-code fw-bolder ticket-data"></span></div>
                        <hr class="col">
                        <div class="col text-nowrap">کد درس: <span class="lesson-code fw-bolder ticket-data"></span></div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center text-center">
                        <div class="col text-nowrap">نام درس: <span class="lesson-name fw-bolder ticket-data"></span></div>
                        <hr class="col">
                        <div class="col text-nowrap">نام کاربر: <span class="user-name fw-bolder ticket-data"></span></div>
                    </div>
                    <fieldset class="py-3 px-4 pm-3 mt-4">
                        <legend class="fw-bolder" style="font-size: 18px">شرح درخواست:</legend>
                        <p class="description ticket-data px-3"></p>
                    </fieldset>
                    <form class="needs-validation" id="ticket_answer_form" novalidate>
                        <div class="form-group mt-3 mx-3">
                            <label for="answer">پاسخ به درخواست</label>
                            <textarea class="form-control" id="answer" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="ticket_answer_form" id="answer_cta" data-row-id="" type="submit" class="btn btn-success">ارسال پاسخ</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer')
    <div class="footer d-flex align-items-center justify-content-between">
        <div class="university-name ms-4">سامانه ثبت تیکت دانشگاه شهید بهشتی</div>
        <div class="me-4">تاریخ: ( <span class="date-place"></span> )</div>
    </div>
@endsection()
@section('script')
    <script type = "module" src="{{ asset('js/support.js') }}"></script>
@endsection()
