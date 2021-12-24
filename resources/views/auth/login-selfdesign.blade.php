@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
@endsection()

@section('title', 'ورود')

@section('content')
    <!-- login -->
    <div class="col d-flex flex-column justify-content-center align-items-center parent-of-cards-signin">
        <div class="user-img-part">
            <i class="fa fa-user"></i>
        </div>

        <div class="login-box p-4 rounded">
            @foreach ($errors->all() as $error)
                <h2>{{ $error }}</h2>
            @endforeach
            <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <label class="form-label label-input-login">نام کاربری</label>
                <div type="text" class="input-group rounded">
                    <span class="input-group-text rounded-start"><i class="fa fa-user"></i></span>
                    <input type="text" tabindex="1" class="form-control rounded-end px-4 input-cleaner" autocomplete="off"
                        name="national_code" value="{{ old('national_code') }}" required>
                </div>
                <label class="form-label label-input-login">رمز عبور</label>
                <div type="text" class="input-group rounded">
                    <span class="input-group-text rounded-start"><i class="fa fa-key"></i></span>
                    <input type="password" tabindex="1" class="form-control rounded-end px-4 pass-input input-cleaner"
                        data-v-min-length="8" autocomplete="off" name="password" required>
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
        <button id="verify-pass" class="btn btn-sm btn-forget-pass btn-light rounded-0 rounded-bottom">رمز عبور خود را
            فراموش کرده اید؟</button>
    </div>
    <div class="col d-flex flex-column justify-content-center align-items-center forget-password d-none">
        <label class="form-label label-input-login">ایمیل خود را وارد کنید</label>
        <div type="text" class="input-group rounded">
            <span class="input-group-text rounded-start"><i class="fa fa-user"></i></span>
            <input type="email" tabindex="1" class="form-control rounded-end px-4 input-cleaner" autocomplete="off"
                name="national_code" value="{{ old('national_code') }}">
        </div>
    </div>
    <!-- end login -->
    <!-- verify -->
    <div class="col d-flex flex-column justify-content-center align-items-center parent-of-cards-verify d-none">
        <div class="verify-box p-4 rounded">
            <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <label class="form-label label-input-verify">ایمیل خود را وارد کنید</label>
                <div type="text" class="input-group rounded">
                    <span class="input-group-text rounded-start"><i class="fa fa-envelope"></i></span>
                    <input type="email" tabindex="1" class="form-control rounded-end px-4 input-cleaner" autocomplete="off"
                        name="national_code" value="{{ old('national_code') }}" required>
                </div>
                <div class="verify-box-footer d-flex justify-content-center">
                    <button type="submit" class="btn w-50 mt-3 rounded btn-dark-self">بازیابی</button>
                </div>
            </form>
        </div>
    </div>
    <!-- end veryfy -->
@endsection()

@section('script')
    <script src="{{ asset('js/login-register.js') }}"></script>
@endsection()
