@extends('frontend.master.layout')
@section('title', $event->name)
@section('content')

    <div class="container">
        {{-- {{dd($event)}} --}}
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
                            $currentDateTime = \Carbon\Carbon::now();
                        @endphp
                        @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') > date('Y-m-d'))
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
                                        <input type="text" name="name" id="name" class="form-control mr-2" />

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" id="verify_coupon" data-eventId= "{{ $event->id }}"
                                            class="btn btn-primary">Verify</button>
                                    </div>
                                    <p class="coupon_error text-danger"></p>

                                </div>


                                <div class="sub_total d-flex  justify-content-between">
                                    <div id="price ">Price / Ticket</div>
                                    <div class="price_val">{{ $event->ticket }}</div>
                                </div>
                                <div class="discount">
                                    <div id="discount_heading"> Discount </div>
                                </div>


                                <button class="btn btn-primary mt-2"
                                    type="submit">{{ __('event_detail_book_ticket') }}</button>

                            </form>
                        @elseif (\Carbon\Carbon::parse($event_date)->format('Y-m-d') == date('Y-m-d') && $start_time > $currentDateTime)
                            <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}"
                                class="booking" method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" />
                                    <button type="submit" class="btn btn-primary">Verify</button>
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label"
                                        for="form7Example2">{{ __('event_detail_coupon_code') }}</label>
                                    <div class="d-flex">
                                        <input type="text" name="name" id="name" class="form-control mr-2" />

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" id="verify_coupon" data-eventId= "{{ $event->id }}"
                                            class="btn btn-primary">Verify</button>
                                    </div>
                                    <p class="coupon_error text-danger"></p>
                                </div>
                                <div class="total">
                                    <div id="price">Price / Ticket</div>
                                    <div class="price_val">{{ $event->ticket }}</div>
                                </div>

                                <button class="btn btn-primary show"
                                    type="submit">{{ __('showEvent.book_ticket') }}</button>

                            </form>
                        @endif
                    </div>

                </div>
                <div class="google-map">
                    <iframe class="mt-5" src="{{ $event->location }}" width="450" height="450" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('contentfooter')

    <script>
        //    import toastr from 'toastr';
        $(document).ready(function() {

            $(document).on('click', '#verify_coupon', function(e) {
                e.preventDefault();

                var action = $('#verify_coupon').html();
                // console.log(action);

                var input = document.getElementById("name");
                var eventId = $(this).attr('data-eventId');
                // alert(eventId);
                var value = input.value;
                // console.log(value);
                var url = "{{ route('user.apply-coupon') }}";

                var token = "{{ csrf_token() }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        name: value,
                        event: eventId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        // console.log(res.message);

                        if (action == 'Verify') {
                            $('#verify_coupon').html('Remove');
                            $("#name").attr('readonly');
                            if (res.error) {
                                toastr.error(res.error.message);
                            } else {
                                toastr.success(res.message);
                                $('.total').html('price/Ticket');
                            }
                        } else if (action == 'Remove') {
                            $('#verify_coupon').html('Verify');
                            $("#name").removeAttr('readonly');
                            $("#form1")[0].reset();
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', xhr);
                        var responseText = xhr.responseText; // Get the response text
                        console.log(responseText);
                        var errorData = JSON.parse(responseText);
                        if (errorData && errorData.message) {
                            // $(".coupon_error").html(errorData.message);
                            toastr.error(errorData.message);
                        } else {
                            console.log('No error message found in the response');
                        }
                    }
                });


            });

        });
    </script>

@endsection
