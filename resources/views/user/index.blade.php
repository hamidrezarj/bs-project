@extends('layouts.base')

@section('content')

<div class="container mt-3">

    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">شماره تیکت</th>
                <th scope="col">شرح درخواست</th>
                <th scope="col">وضعیت</th>
                <th scope="col">تاریخ ثبت</th>
                <th scope="col">مشاهده</th>
            </tr>
        </thead>
        <tbody>

            @foreach($tickets as $ticket)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $ticket->status }}</td>
                <td>{{ $ticket->created_at_fa }}</td>
                <td><a href="{{ route('ticket_details', ['ticket' => $ticket->id]) }}" class="link-primary">مشاهده</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
        <a href="{{ route('ticket_form') }}" class="btn btn-primary" tabindex="-1" aria-disabled="true">ایجاد تیکت جدید</a>
    </div>

</div>
@endsection