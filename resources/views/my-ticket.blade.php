{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body>
    <h1>Ticket </h1>
    <p>Name: {{$owner_name}} </p> 
    <p>Event Name: {{$event_name}}</p>
    <p>Ticket Number: {{$ticket_number}}</p>
    <p>Per Ticket Price: {{$price_per_ticket}}</p>
    <p>No. of Tickets: {{$quantity}}</p>
    <p>Total Amount : {{$total}}</p>
    <p>Discount: {{$discount}}</p>
    <p>Hosted By: {{$host_company}}</p>

</body>
</html> --}}


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
			.qr-holder > img {
				margin-top: 20px;
			}
			.event {
				font-size: 24px;
				color: #fff;
				letter-spacing: 1px;
			}
			.date {
				font-size: 18px;
				line-height: 30px;
				color: #a8bbf8;
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
			<div class="column-1">
				<div class="text-frame">
					<div class="event">{{$event_name}}</div>
					<div class="date">{{$date}}</div>
					<br />
					<div class="name">{{$owner_name}}</div>
					<div class="ticket-id"> {{$ticket_number}} </div>
				</div>
			</div>

			<div class="column-2">
				<div class="qr-holder">

					{!! $booking_number !!}
					
					{{-- <img src="data:image/png;base64, <?php // echo base64_encode(QrCode::size(120)->generate($booking_number)); ?>" /> --}}

					{{-- <img src="{!! $ticket_number !!}" width="120px" height="120px" /> --}}
				</div>

			</div>
		</div>

		<div >
			{{-- {{QrCode::size(120)->generate(231011090)}} --}}
		</div>
	</body>
</html>