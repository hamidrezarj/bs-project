@extends('errors::minimal')

@section('title', 'صفحه یافت نشد')
@section('content')
    <div class="h-100 404-notfound p-4 d-flex flex-column align-items-center justify-content-center">
        <h4 class="mt-3 bg-white text-dark p-3 rounded-pill">صفحه مورد نظر یافت نشد | 404</h4>
        <a href="{{ url()->previous() }}" class="btn text-white">بازگشت به صفحه قبلی</a>
    </div>
@endsection
