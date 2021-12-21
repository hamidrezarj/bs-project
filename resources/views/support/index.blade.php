@extends('layouts.base')

@section('content')

    <div class="container mt-3">

        <h3>{{ $support->full_name }}</h3>

        @if (Cache::has('user-is-online-' . $support->id))
            <span class="text-success">فعال</span>

            <a href="{{ route('support.deactivate') }}" onclick="event.preventDefault();
                    document.getElementById('deactivate-form').submit();">
                غیرفعال سازی
            </a>

            <form id="deactivate-form" action="{{ route('support.deactivate') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <span class="text-secondary">غیرفعال</span>

            <a href="{{ route('support.activate') }}" onclick="event.preventDefault();
                    document.getElementById('activate-form').submit();">
                فعال سازی
            </a>

            <form id="activate-form" action="{{ route('support.activate') }}" method="POST" class="d-none">
                @csrf
            </form>

        @endif

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

                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td><a href="{{ route('support.ticket_details', ['ticket' => $ticket->id]) }}"
                                class="link-primary">ارسال پاسخ</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $tickets->links() }}
        </div>

    </div>
@endsection
