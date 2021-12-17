@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection()

@section('title', 'ورود')

@section('content')
        <!-- login -->
        <div class="col d-flex flex-column justify-content-center align-items-center parent-of-cards-signin">
            <div class="user-img-part">
                <i class="fa fa-user"></i>
            </div>
            <div class="login-box p-4 rounded">
                <form class="needs-validation" method="POST" action="{{ route('login') }}">
                    @csrf
                    <label class="form-label label-input-login">نام کاربری</label>
                    <div type="text" class="input-group rounded">
                        <span class="input-group-text rounded-start"><i class="fa fa-user"></i></span>
                        <input type="text" tabindex="1" class="form-control rounded-end px-4 input-cleaner" autocomplete="off" name="national_code" value="{{ old('national_code') }}">
                    </div>
                    <label class="form-label label-input-login">رمز عبور</label>
                    <div type="text" class="input-group rounded">
                        <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                        <input type="password" tabindex="1" class="form-control rounded-end px-4 pass-input input-cleaner" autocomplete="off" name="password">
                        <span class="input-group-text rounded-start eye-pass"><i class="fa fa-eye-slash"></i></span>
                    </div>
                    <div class="login-box-footer d-flex justify-content-center">
                        <button type="submit" class="btn w-50 mt-3 rounded btn-dark-self">ورود</button>
                    </div>
                    <div class="mt-4 d-flex justify-content-center align-items-center">
                        <hr class="col">
                        <p id="signUp" class="col up-or-in text-nowrap text-center mx-2 mb-0">ایجاد حساب کاربری</p>
                        <hr class="col">
                    </div>
                </form>
            </div>
            <button class="btn btn-sm btn-forget-pass btn-light rounded-0 rounded-bottom">رمز عبور خود را فراموش کرده اید؟</button>
        </div>
        <div class="col d-flex flex-column justify-content-center align-items-center forget-password d-none">
            <label class="form-label label-input-login">ایمیل خود را وارد کنید</label>
            <div type="text" class="input-group rounded">
                <span class="input-group-text rounded-start"><i class="fa fa-user"></i></span>
                <input type="email" tabindex="1" class="form-control rounded-end px-4 input-cleaner" autocomplete="off" name="national_code" value="{{ old('national_code') }}">
            </div>
        </div>
        <!-- end login -->
        <!-- register -->
        <div class="col d-flex flex-column justify-content-center align-items-center parent-of-cards-signup d-none">
            <div class="register-box p-4 rounded">
                <form class="needs-validation" method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <label class="form-label label-input-login">نوع کاربر</label>
                    <div type="text" class="input-group rounded">
                        <span class="input-group-text rounded-start"><i class="fa fa-user-circle" style="font-size: 20px"></i></span>
                        <select id="user_type" type="text" tabindex="1" class="form-select rounded-end px-4 select-cleaner" autocomplete="off">
                            <option disabled selected value="">انتخاب نوع کاربر</option>
                            <option value="1">دانشجو</option>
                            <option value="2">استاد</option>
                            <option value="3">کارشناس آموزش</option>
                            <option value="4">پشتیبان فنی</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div style="width: 30%">
                            <label class="form-label label-input-login">نام</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                        <div style="width: 30%">
                            <label class="form-label label-input-login">نام خانوادگی</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                        <div style="width: 30%">
                            <label class="form-label label-input-login">کد ملی</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div style="width: 47%">
                            <label class="form-label label-input-login">شماره تلفن</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                        <div style="width: 47%">
                            <label class="form-label label-input-login">ایمیل</label>
                                <input type="email" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div style="width: 30%">
                            <label class="form-label label-input-login">دانشکده</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div> 
                        <div style="width: 30%" class="refer-to-student d-none">
                            <label class="form-label label-input-login">رشته</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                        <div style="width: 30%" class="refer-to-student d-none">
                            <label class="form-label label-input-login">شماره دانشجویی</label>
                            <input type="text" tabindex="1" class="form-control rounded px-4 input-cleaner" autocomplete="off">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div style="width: 47%">
                            <label class="form-label label-input-login">رمز عبور</label>
                            <div type="text" class="input-group rounded">
                                <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                <input type="password" tabindex="1" class="form-control rounded-end px-4 pass-input input-cleaner" autocomplete="off" name="password">
                                <span class="input-group-text rounded-start eye-pass"><i class="fa fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div style="width: 47%">
                            <label class="form-label label-input-login">تکرار رمز عبور</label>
                            <div type="text" class="input-group rounded">
                                <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                                <input type="password" tabindex="1" class="form-control rounded-end px-4 pass-input input-cleaner" autocomplete="off" name="password">
                                <span class="input-group-text rounded-start eye-pass"><i class="fa fa-eye-slash"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="login-box-footer d-flex justify-content-center">
                        <button type="submit" class="btn w-50 mt-3 rounded btn-dark-self">ثبت نام</button>
                    </div>
                    <div class="mt-4 d-flex justify-content-center align-items-center">
                        <hr class="col">
                        <p id="signIn" class="col up-or-in text-nowrap text-center mx-2 mb-0">ورود به حساب کاربری</p>
                        <hr class="col">
                    </div>
                </form>
            </div>
        </div>
        <!-- end register -->
@endsection()

@section('script')
    <script src="{{asset('js/login.js')}}"></script>
@endsection()