@extends('layouts.base')

@section('content')

<div class="container mt-3">

    <form action="{{ route('create_ticket') }}" method="POST">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('course_name') is-invalid @enderror" name="course_name" id="courseName" value="{{ old('course_name') }}" placeholder="Course Name" required>
            <label for="courseName">نام درس</label>

            @error('course_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('course_id') is-invalid @enderror" name="course_id" id="courseId" value="{{ old('course_id') }}" placeholder="Course ID" required>
            <label for="courseId">کد درس</label>

            @error('course_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Leave a comment here" id="description" value="{{ old('description') }}" style="height: 100px" required></textarea>
            <label for="description">شرح درخواست</label>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">ثبت تیکت</button>
    </form>

</div>

@endsection