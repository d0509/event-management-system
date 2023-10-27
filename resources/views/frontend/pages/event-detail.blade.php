@extends('frontend.master.layout')
@section('title', $event->name)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($event->media as $item)
                    <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                        style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid text-center"
                        alt="Event fvv" />
                @endforeach
                <h3 class="mt-5">{{ __('event_detail_details') }}</h3>
                <h4 class="fw-bold mt-2">{{ ucwords($event->name) }}</h4>
                <p class="mt-5">{{ $event->description }}</p>
                <p class="text-dark font-weight-bold">** {{ __('event_detail_note') }} **</p>
                <p class="fs-5 ml-2">{{ __('event_detail_note_msg') }}</p>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-chair"></i></p>
                            <p class="col-10 text-dark">{{ $event->available_seat }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-solid fa-location-dot"></i></p>
                            <p class="col-10 text-dark">{{ $event->venue }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-solid fa-calendar-days"></i></p>
                            <p class="col-10 text-dark">
                                {{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format')) }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                            <p class="col-10 text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                        </div>

                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa fa-inr" aria-hidden="true"></i> </p>
                            <p class="col-10 text-dark">{{ $event->ticket }}</p>
                        </div>
                        @php
                            $event_date = $event->event_date;
                            $start_time = $event->start_time;
                            $currentDate = \Carbon\Carbon::now()->toDateString();
                            $currentDateTime = \Carbon\Carbon::now()->toTimeString();
                        @endphp
                        {{-- {{dd($event_date)}} --}}
                        {{-- {{dd($currentDateTime)}} --}}
                        {{-- {{dd($event_date == $currentDate)}} --}}
                        {{-- {{dd($currentDate)}} --}}
                        @if ($event_date > $currentDate)
                            <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}"
                                class="booking" method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" />
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label"
                                        for="form7Example2">{{ __('event_detail_coupon_code') }}</label>
                                    <div class="d-flex">
                                        <input type="text" name="code" id="code" class="form-control mr-2" />

                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button id="verify_coupon" data-eventId= "{{ $event->id }}"
                                            class="btn btn-primary"> {{ __('event_details_verify') }} </button>
                                    </div>
                                    <p class="coupon_error text-danger"></p>

                                </div>

                                <p class="fw-bold"> {{ __('event_details_price_detail') }} </p>
                                <div class="quantity d-flex  justify-content-between">
                                    <div id="quantity_heading"> {{ __('event_details_quantity') }} </div>
                                    <div id="quantity_val"> 1 </div>
                                </div>
                                <div class="sub_total mt-2 d-flex  justify-content-between">
                                    <div id="price_heading"> {{__('event_details_ticket_price') }} </div>
                                    <div class="price_val">{{ $event->ticket }}</div>
                                </div>
                                <div class="discount mt-2 d-flex justify-content-between ">
                                    <div id="discount_heading"> {{ __('event_details_discount') }} </div>

                                    <div id="discount_value">- 0 </div>
                                </div>
                                <hr>
                                <div class="total mt-2 d-flex justify-content-between ">
                                    <div id="total_heading"> {{ __('event_details_total') }} </div>
                                    <div id="total_value"> {{ $event->ticket }} </div>
                                </div>

                                <button class="btn btn-primary mt-2"
                                    type="submit">{{ __('event_detail_book_ticket') }}</button>

                            </form>
                        @elseif ($event_date == $currentDate && $start_time > $currentDateTime)
                        <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}"
                            class="booking" method="post">
                            @csrf
                            <div>
                                <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" />
                                @error('quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label"
                                    for="form7Example2">{{ __('event_detail_coupon_code') }}</label>
                                <div class="d-flex">
                                    <input type="text" name="code" id="code" class="form-control mr-2" />

                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button id="verify_coupon" data-eventId= "{{ $event->id }}"
                                        class="btn btn-primary"> {{ __('event_details_verify') }} </button>
                                </div>
                                <p class="coupon_error text-danger"></p>

                            </div>

                            <p class="fw-bold"> {{ __('event_details_price_detail') }} </p>
                            <div class="quantity d-flex  justify-content-between">
                                <div id="quantity_heading"> {{ __('event_details_quantity') }} </div>
                                <div id="quantity_val"> 1 </div>
                            </div>
                            <div class="sub_total mt-2 d-flex  justify-content-between">
                                <div id="price_heading"> {{__('event_details_ticket_price') }} </div>
                                <div class="price_val">{{ $event->ticket }}</div>
                            </div>
                            <div class="discount mt-2 d-flex justify-content-between ">
                                <div id="discount_heading"> {{ __('event_details_discount') }} </div>

                                <div id="discount_value">- 0 </div>
                            </div>
                            <hr>
                            <div class="total mt-2 d-flex justify-content-between ">
                                <div id="total_heading"> {{ __('event_details_total') }} </div>
                                <div id="total_value"> {{ $event->ticket }} </div>
                            </div>

                            <button class="btn btn-primary mt-2"
                                type="submit">{{ __('event_detail_book_ticket') }}</button>

                        </form>
                        @endif
                    </div>

                </div>
                <div class="google-map">
                    <iframe class="mt-5" src="{{ $event->location }}" width="450" height="450"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('contentfooter')

    <script>
        $(document).ready(function() {
            // Function to update discount and total values
            function updatePriceDetails(quantity, discountAmount, totalAmount, ticketPrice) {
                $('#price_val').text(ticketPrice);
                $('#quantity_val').text(quantity);
                $('#discount_value').html('-' + discountAmount);
                $('#total_value').text(totalAmount);
            }

            // Verify Coupon button click event
            $(document).on('click', '#verify_coupon', function(e) {
                e.preventDefault();
                var input = document.getElementById("code");
                var quantity = $('#quantity').val();
                quantity = quantity ? parseInt(quantity) : 1; // Parse as an integer
                var eventId = $(this).attr('data-eventId');
                var value = input.value;
                var url = "{{ route('user.apply-coupon') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        code: value,
                        event: eventId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        $('#verify_coupon').html('Remove');
                        input.readOnly = true;
                        $('#verify_coupon').attr('id', 'coupon_verified');
                        var discountAmount = quantity * res.discountAmount;
                        var totalAmount = quantity * res.totalAmount;
                        var ticket = quantity * res.ticket;
                        updatePriceDetails(quantity, discountAmount, totalAmount, ticket);

                        if (res.error) {
                            toastr.error(res.error.message);
                        } else {
                            toastr.success(res.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', xhr);
                        var responseText = xhr.responseText;
                        // console.log(responseText);
                        var errorData = JSON.parse(responseText);
                        if (errorData && errorData.message) {
                            // toastr.error(errorData.message);
                        }
                    }
                });
            });

            // Quantity input change event
            $(document).on('change', '#quantity', function(e) {
                var quantity = parseInt($(this).val()); // Parse the input as an integer
                var ticketPrice = parseFloat('{{ $event->ticket }}');

                // Check if quantity and ticketPrice are valid numbers
                if (!isNaN(quantity) && !isNaN(ticketPrice)) {
                    var discountAmount = quantity * parseFloat($('#discount_value').text());
                    var totalAmount = ticketPrice - discountAmount;
                    updatePriceDetails(quantity, discountAmount, totalAmount, ticketPrice);
                } else {
                    // Handle the case where the values are not valid numbers (e.g., display an error message)
                    console.log('Invalid quantity or ticket price');
                }
            });
        });
    </script>




@endsection
