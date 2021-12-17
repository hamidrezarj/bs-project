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

    @if($ticket->status == 'answered' || $ticket->status == 'completed')
        <div class="form-floating mb-3">
            <textarea class="form-control" name="reply_description" placeholder="Leave a comment here" id="replyDesc" style="height: 100px" readonly>{{ $ticket->ticket_answer->description }}</textarea>
            <label for="description">پاسخ پشتیبان</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="reply_date" id="replyDate" value="{{ $ticket->ticket_answer->reply_date }}" placeholder="Course ID" readonly>
            <label for="replyDate">زمان پاسخ</label>
        </div>
    @endif

    @if($ticket->status == 'answered')
        <h4>امتیازدهی به پاسخ پشتیبان</h4>
        
        <form action="{{ route('ticket.vote', ['ticket' => $ticket->id]) }}" method="POST">
            @csrf

            @foreach ($errors->all() as $error)
                <div class="text-danger" role="alert">
                    <strong>{{ $error }}</strong>
                </div>  
            @endforeach

            <div class="form-check form-check-inline mt-3">
                <input class="form-check-input" type="radio" id="inlineRadio1" name="user_vote" value="5" required>
                <label class="form-check-label" for="inlineRadio1">عالی</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="user_vote" value="4">
                <label class="form-check-label" for="inlineRadio2">خوب</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio3" name="user_vote" value="3">
                <label class="form-check-label" for="inlineRadio3">متوسط</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio4" name="user_vote" value="2">
                <label class="form-check-label" for="inlineRadio4">ضعیف</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio5" name="user_vote" value="1">
                <label class="form-check-label" for="inlineRadio5">بسیار ضعیف</label>
            </div>

            <button class="btn btn-primary d-block mt-3" type="submit">ثبت</button>
        </form>
    @endif

    @if ($message = session('status'))
    <div class="alert alert-success" role="alert">
        <strong>{{ $message }}</strong>
    </div>  
    @endif

</div>

@endsection