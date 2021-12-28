@extends('errors::minimal')

@section('title', 'خطای سرور')
@section('content')
    <div class="h-100 404-notfound p-4 d-flex flex-column align-items-center justify-content-center">
        <h4 class="mt-3 bg-white text-dark p-3 rounded-pill">سرور دچار مشکل شده است | 503</h4>
        <a href="{{ url()->full() }}" class="btn text-white">بارگزاری مجدد صفحه</a>
    </div>
@endsection