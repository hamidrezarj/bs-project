@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection()

@section('title', 'کاربر')

@section('profile')
    <div class="profile-part mb-5">
        <div class="user-profile-img rounded d-flex justify-content-center align-items-center">
            <i class="fa fa-user"></i>
        </div>
        <h6 id="user_fullName"></h6>
        <div class="profile-button-parent">
            <button id="user_data" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="اطلاعات کاربر" class="btn btn-sm btn-default"><i class="fa fa-user"></i></button>
            <button id="edit_profile" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ویرایش پروفایل" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></button>
            <button id="reset_pass" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="تغییر رمز عبور" class="btn btn-sm btn-default"><i class="fas fa-key"></i></button>
            <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><button type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="خروج" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i></button></a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-action-parent justify-content-center">
        <button id="add_ticket" class="btn add-self-design btn-sm d-flex align-items-center mx-auto">ثبت تیکت جدید <i class="fa fa-plus ms-1"></i></button>
    </div>
    <hr>
    <div class="table-parent">
        <table id="user_table" class="table table-striped table-bordered table-self-style" style="width: 100%;">
            <thead>
                <tr>
                    <th class="filter-none text-center">ردیف</th>
                    <th class="filter-text text-center">شماره تیکت</th>
                    <th class="filter-text text-center">نام درس</th>
                    <th class="filter-text text-center">کد درس</th>
                    <th class="filter-text text-center">شرح درخواست</th>
                    <th class="filter-select text-center" data-select-name='[" در انتظار پاسخ" , "پاسخ داده شده", "تکمیل شده" , "نا موفق" ]' data-select-value='[1,2,3,4]'>وضعیت</th>
                    <th class="filter-date text-center">تاریخ انقضا</th>
                    <th class="filter-date text-center">تاریخ ثبت</th>
                    <th class="filter-none text-center">عملیات</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="add_ticket_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form class="needs-validation" id="add_ticket_form" novalidate>
                    <div class="modal-header">
                        <h6 class="modal-title">ثبت تیکت</h6>
                        <button type="button" class="close p-0 m-0 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col-5 my-2">
                                <label for="course_name" class="form-label">نام درس</label>
                                <input id="course_name" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-name" required>
                            </div>
                            <div class="col-5 my-2">
                                <label for="course_id" class="form-label">کد درس</label>
                                <input id="course_id" type="text" tabindex="1" class="form-control input-cleaner" autocomplete="off"
                                name="lesson-code" required>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                        <label for="description" class="form-label">شرح درخواست</label>
                            <textarea id="description" class="form-control textarea-cleaner" name="request-body" cols="5" rows="3" required></textarea>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button form="add_ticket_form" id="add_ticket_cta" type="submit" class="btn btn-success">ثبت</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="description_modal" tabindex="-1" aria-hidden="true">
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
    <div class="modal fade" id="ticket_answer_voting_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body my-2">
                    <div class="d-flex justify-content-center align-items-center text-center">
                        <hr class="col">
                        <div class="col text-nowrap">نام کارشناس: <span class="who-answered fw-bolder"></span></div>
                        <hr class="col">
                    </div>
                    <div class="mt-4">
                        <h6>پاسخ کارشناس: </h6>
                        <div class="p-3 border rounded">
                            <p class="answer w-100"></p>
                        </div>
                    </div>
                    <h6 class="mt-4 text-danger">*برای تکمیل تیکت خود و بهبود عملکرد کارشناسان لطفا بخش نظرسنجی را تکمیل کنید.</h6>
                    <div class="mt-1">
                        <div class="d-flex justify-content-center align-items-center text-center">
                            <hr class="col">
                            <div class="col text-nowrap">بررسی عملکرد کارشناس</div>
                            <hr class="col">
                        </div>
                        <div class="mt-3 mb-3 text-center">
                            <h6>عملکرد کارشناس مربوطه را چطور ارزیابی میکنید؟</h6>
                            <form class="needs-validation" id="voting_form" novalidate>
                                <div class="mt-2">
                                    <label class="form-check-label" for="worst">بسیار ضعیف</label>
                                    <input class="form-check-input radio-vote" type="radio" data-vote-id-input="1" name="vote" id="worst" required>
                                    <label class="form-check-label" for="bad">ضعیف</label>
                                    <input class="form-check-input radio-vote" type="radio" data-vote-id-input="2" name="vote" id="bad" required>
                                    <label class="form-check-label" for="normal">متوسط</label>
                                    <input class="form-check-input radio-vote" type="radio" data-vote-id-input="3" name="vote" id="normal" required>
                                    <label class="form-check-label" for="good">خوب</label>
                                    <input class="form-check-input radio-vote" type="radio" data-vote-id-input="4" name="vote" id="good" required>
                                    <label class="form-check-label" for="excellent">عالی</label>
                                    <input class="form-check-input radio-vote" type="radio" data-vote-id-input="5" name="vote" id="excellent" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button form="voting_form" id="voting_cta" data-row-id="" data-vote-id="" type="submit" class="btn btn-success">ارسال نظر</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ticket_answer_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body my-2">
                    <div class="d-flex justify-content-center align-items-center text-center">
                        <hr class="col">
                        <div class="col text-nowrap">نام کارشناس: <span class="who-answered fw-bolder"></span></div>
                        <hr class="col">
                    </div>
                    <div class="mt-4">
                        <h6>پاسخ کارشناس: </h6>
                        <div class="p-3 border rounded">
                            <p class="answer w-100"></p>
                        </div>
                    </div>
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
    <script type = "module" src="{{ asset('js/user.js') }}"></script>
@endsection()