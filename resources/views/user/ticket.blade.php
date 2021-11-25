@extends('layouts.base')

@section('content')

<div class="container mt-3">

    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="course_name" id="courseName" value="{{ $ticket->course_name }}" placeholder="Course Name" readonly>
        <label for="courseName">نام درس</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="course_id" id="courseId" value="{{ $ticket->course_id }}" placeholder="Course ID" readonly>
        <label for="courseId">کد درس</label>
    </div>
    <div class="form-floating mb-3">
        <textarea class="form-control" name="description" placeholder="Leave a comment here" id="description" style="height: 100px" readonly>{{ $ticket->description }}</textarea>
        <label for="description">شرح درخواست</label>
    </div>

</div>

@endsection