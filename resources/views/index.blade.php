@extends('layouts.base')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="container">
    <h3>Here is our main content!</h3>
</div>
@endsection