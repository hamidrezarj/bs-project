@extends('layouts.base')

@section('content')

<div class="container mt-3">

    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="id" id="ticketID" value="{{ $ticket->id }}" placeholder="Course Name" readonly>
        <label for="ticketID">شماره تیکت</label>
    </div>

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

    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="created_at" id="createdAt" value="{{ $ticket->created_at }}" placeholder="Created At" readonly>
        <label for="courseId">تاریخ ثبت</label>
    </div>

    <form action="{{ route('support.reply_ticket', ['ticket' => $ticket->id]) }}" method="POST">
        @csrf

        <div class="form-floating mb-3">
            <textarea class="form-control" name="description" placeholder="توضیحات" id="description" style="height: 100px" required></textarea>
            <label for="description">توضیحات</label>

            @error('description')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">ثبت پاسخ</button>
    </form>

</div>

@endsection