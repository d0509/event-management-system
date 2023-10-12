<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-size: 16px;
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
        }

        .container {
            width: 602px;
            height: 200px;
            margin: 0 auto;
            border-radius: 4px;
            background-color: #4537de;
            box-shadow: 0 8px 16px rgba(35, 51, 64, 0.25);
        }

        .page-break {
            page-break-after: always;
        }

        .column-1 {
            float: left;
            width: 400px;
            height: 200px;
            border-right: 2px dashed #fff;
        }

        .column-2 {
            float: right;
            width: 200px;
            height: 200px;
        }

        .text-frame {
            padding: 40px;
            height: 120px;
        }

        .qr-holder {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 20px;
            background-color: #fff;
            text-align: center;
            line-height: 30px;
            z-index: 1;
        }

        .qr-holder>img {
            margin-top: 20px;
        }

        .event {
            font-size: 18px;
            color: #fff;
            letter-spacing: 1px;
        }

        .date {
            font-size: 16px;
            line-height: 30px;
            color: #fff;
        }

        .name,
        .ticket-id {
            font-size: 16px;
            line-height: 22px;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
		{{-- <div class="page-break"></div> --}}
        <div class="column-1">
            <div class="text-frame">
                <div class="event">Booking Number: {{ $ticket_number }}</div>
                <div class="name">Event Name: {{ $event_name }}</div>
                <div class="name">Event Date: {{ $date }}
                    {{ Carbon\Carbon::parse($start_time)->format(config('site.time_format')) }} </div>
                <br />
                <div class="name">Name: {{ $owner_name }}</div>
                <div class="name">No. of Bookings: {{ $person }}</div>
                {{-- <div class="ticket-id">Time:{{ Carbon\Carbon::parse($start_time)->format(config('site.time_format'))}} </div> --}}
            </div>
        </div>

        <div class="column-2">
            <div class="qr-holder">
                <img src="data:image/png;base64, {!! $qr_code !!}">

                {{-- <img src="{!! $ticket_number !!}" width="120px" height="120px" /> --}}
            </div>

        </div>
    </div>
	<div style="page-break-after:auto;">
    

</body>

</html>
