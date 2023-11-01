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
                            $eventDateTime = \Carbon\Carbon::parse($event->event_date . ' ' . $event->start_time)->toDateTimeString();
                            $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
                        @endphp
                        @if ($eventDateTime > $currentDateTime)
                            <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}"
                                class="booking" method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                    <input type="number" min="1" name="quantity" id="quantity"
                                        class="qty form-control" />
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label"
                                        for="form7Example2">{{ __('event_detail_coupon_code') }}</label>
                                    <div class="d-flex">
                                        <input type="text" name="code" id="code" class="form-control mr-2" />

                                        <a id="verify_coupon" data-eventId= "{{ $event->id }}"
                                            class="btn btn-primary text-light"> {{ __('event_details_verify') }} </a>
                                    </div>
                                    <p class="coupon_error text-danger"></p>

                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <p class="fw-bold"> {{ __('event_details_price_detail') }} </p>
                                <div class="quantity d-flex  justify-content-between">
                                    <div id="quantity_heading"> {{ __('event_details_quantity') }} </div>
                                    <div id="quantity_val"> 1 </div>
                                </div>
                                <div class="sub_total mt-2 d-flex  justify-content-between">
                                    <div id="price_heading"> {{ __('event_details_ticket_price') }} </div>
                                    <div class="price_val" id="totalPrice">{{ $event->ticket }}</div>
                                </div>
                                <div class="discount mt-2 d-flex justify-content-between" style="display: none !important">
                                    <div id="discount_heading"> {{ __('event_details_discount') }} (<span
                                            id="discount_percentage"></span>%) </div>
                                    <div>- <span id="discount_value">0</span> </div>
                                </div>
                                <hr>
                                <div class="total mt-2 d-flex justify-content-between ">
                                    <div id="total_heading"> {{ __('event_details_total') }} </div>
                                    <div id="discountTotalPrice"> {{ $event->ticket }} </div>
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
            function updatePriceDetails(quantity, discountAmount, totalAmount, ticketPrice, discountPercentage) {
                $('#price_val').text(ticketPrice.toFixed(2));
                $('#quantity_val').text(quantity);
                $('#discount_value').html(discountAmount.toFixed(2));
                $('#discountTotalPrice').text(totalAmount.toFixed(2));
                $("#discount_percentage").text(discountPercentage);
            }

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
                        console.log(res);
                        input.readOnly = true;
                        $('#verify_coupon').attr('id', 'coupon_verified');
                        $('.discount').children().show();
                        var discountPercentage = res.discountPercentage;
                        var discountAmount = quantity * res.discountAmount;
                        console.log(discountPercentage);
                        var totalAmount = quantity * res.totalAmount;
                        var ticket = quantity * res.ticket;
                        updatePriceDetails(quantity, discountAmount, totalAmount, ticket,
                            discountPercentage);
                        $(".discount").css("display", "");
                        $(".discount").show();
                        if (res.error) {
                            toastr.error(res.error.message);
                        } else {
                            toastr.success(res.message);
                        }

                        $("#verify_coupon").removeAttr('id');
                        console.log($(this).attr('id'));
                        $("#quantity").attr('readonly', 'readonly');


                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', xhr);
                        var responseText = xhr.responseText;
                        // console.log(responseText);
                        var errorData = JSON.parse(responseText);
                        if (errorData && errorData.message) {
                            toastr.error(errorData.message);
                        }
                    }
                });
            });

            $(document).on('click', '#coupon_verified', function(e) {
                e.preventDefault();
                $('#coupon_verified').text('Verify');
                $(".discount").children().hide();
                $("#code").val('');
                $('#code').removeAttr('readonly');
                $("#quantity").removeAttr('readonly');
                $("#coupon_verified").attr('id', 'verify_coupon');
                var quantity = parseInt($('#quantity').val());
                if (isNaN(quantity)) {
                    quantity = 1;
                }
                var ticketPrice = parseFloat('{{ $event->ticket }}');
                var discountTotalPrice = quantity * ticketPrice;
                console.log(discountTotalPrice);
                $("#discountTotalPrice").text(discountTotalPrice);
            });

            $(document).on('input change', '.qty', function(e) {

                var quantity = parseInt($(this).val());

                if (isNaN(quantity)) {
                    quantity = 1;
                }

                var ticketPrice = parseFloat('{{ $event->ticket }}');
                var totalTicketPrice = quantity * ticketPrice;
                let total = quantity * ticketPrice;
                let discountPrice = $('#discount_value').html();
                let totalDiscount = quantity * discountPrice;
                // console.log(totalDiscount);
                if (!total) {
                    $('#totalPrice').html(ticketPrice.toFixed(2));
                } else {
                    $('#totalPrice').html(total.toFixed(2));
                }

                let grandTotal = totalTicketPrice - totalDiscount;
                $("#discountTotalPrice").html(grandTotal.toFixed(2));
                $("#totalPrice").text(totalTicketPrice.toFixed(2));
                $("#quantity_val").text(quantity);
                $("#discount_value").text(totalDiscount.toFixed(2));
            });


        });
    </script>




@endsection
