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
        <div class="profile-button-parent">
            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="ویرایش پروفایل" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></button>
            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="تغییر رمز عبور" class="btn btn-sm btn-default"><i class="fas fa-key"></i></button>
            <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="خروج" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i></button>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-parent">
        <table id="user_table" class="table table-striped table-bordered table-self-style" style="width: 100%;">
            <thead>
                <tr>
                    <th class="filter-none text-center">ردیف</th>
                    <th class="filter-text text-center">شماره تیکت</th>
                    <th class="filter-text text-center">نام درس</th>
                    <th class="filter-text text-center">کد درس</th>
                    <th class="filter-text text-center">شرح درخواست</th>
                    <th class="filter-select text-center" data-select-name='["غیرفعال", "فعال"]' data-select-value='[0,1]'>وضعیت</th>
                    <th class="filter-date text-center">تاریخ انقضا</th>
                    <th class="filter-date text-center">تاریخ ثبت</th>
                    <th class="filter-date text-center">تاریخ بروزرسانی</th>
                    <th class="filter-none text-center">عملیات</th>


                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script type = "module" src="{{ asset('js/user.js') }}"></script>
@endsection()