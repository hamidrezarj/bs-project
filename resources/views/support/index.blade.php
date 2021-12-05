@extends('layouts.base')

@section('content')

<div class="container mt-3">

    <h3>{{ $support->full_name }}</h3>

    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">شماره تیکت</th>
                <th scope="col">شرح درخواست</th>
                <th scope="col">وضعیت</th>
                <th scope="col">عملیات</th>
            </tr>
        </thead>
        <tbody>

            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $ticket->status }}</td>
                <td><a href="{{ route('support.ticket_details', ['ticket' => $ticket->id]) }}" class="link-primary">ارسال پاسخ</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>

</div>
@endsection