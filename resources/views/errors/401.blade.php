@extends('errors::minimal')
@section('title', 'خطا در اهراز هویت')
@section('content')
    <div class="h-100 401-unauthorized p-4 d-flex flex-column align-items-center justify-content-center">
        <h4 class="mt-3 bg-white text-dark p-3 rounded-pill"> هویت شما مورد تایید نمی باشد | 401</h4>
        <a href="{{route('login')}}" class="btn text-white">رفتن به صفحه ورود</a>
    </div>
@endsection