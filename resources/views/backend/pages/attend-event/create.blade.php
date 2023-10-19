@extends('backend.master.layout')
@section('title', 'Attend Event')
@section('content')
    {{-- <div id="qr_code_modal"  class="modal fade " style="margin: 0 auto" tabindex="-1">
        <div class="col-sm-6">
            <video id="preview" class="p-1 border" style="width:50%;"></video>
        </div>
    </div> --}}
    <div class="modal fade" id="qr_code_modal" 
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <video id="preview" width="100%"></video>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal_close_button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('dashboard.attend_event') }}</h1>
            <a href="{{ route('company.attend-event.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> <i
                    class="fas fa-users mr-2"></i>{{ __('dashboard.attendee_list') }}</a>

        </div>
{{-- {{$todayEvents}} --}}
        <form action="{{ route('company.attend-event.store') }}" method="post">
            @csrf
            <div class="form-outline mb-4">
                <label for="exampleFormControlInput1" class="form-label">Event Name</label>
                <select class="form-control" name="event_id" aria-label="Default select example">
                    <option value="default"> Please select an event </option>
                    @foreach ($todayEvents as $todayEvent)
                        <option value="{{ $todayEvent->id }}">{{ $todayEvent->name }}</option>
                    @endforeach
                </select>
                @error('event_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Booking Number</label>
                <input type="text" name="booking_number" id="booking_number" class="form-control"
                    placeholder="Booking number" value="{{ old('booking_number') }}" />
                @error('booking_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <a id="btn-qr-code" class="text-gray cursor-pointer">Click to scan QR Code.</a>
            </div>


            <div class="form-outline mb-4">
                <label for="exampleFormControlInput1" class="form-label">No. of Attendee</label>
                <input type="number" name="no_of_attendee" class="form-control" placeholder="No. of attendee">
                @error('no_of_attendee')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-5 ">Attend</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
           
            // $(".text-gray").click(function() {
            //     $("#qr_code_modal").modal('show');
            // });

            $(document).on('click', '#btn-qr-code', function() {
                // alert('you opened scanner');
                $("#qr_code_modal").modal('show');

                var scanner = new Instascan.Scanner({
                    video: document.getElementById('preview'),
                    scanPeriod: 5,
                    mirror: false
                });
                scanner.addListener('scan', function(content) {
                    // console.log("cslll");
                    // alert(content);
                    $('#booking_number').val(content);
                    $('#qr_code_modal').modal('hide');
                    scanner.stop();

                });
                $(document).on('click', '.close', function() {
                    scanner.stop();
                });

                $(document).on('click', '#modal_close_button', function() {
                    scanner.stop();
                });
                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                        $('[name="options"]').on('change', function() {
                            if ($(this).val() == 1) {
                                if (cameras[0] != "") {
                                    scanner.start(cameras[0]);
                                } else {
                                    alert('No Front camera found!');
                                }
                            } else if ($(this).val() == 2) {
                                if (cameras[1] != "") {
                                    scanner.start(cameras[1]);
                                } else {
                                    alert('No Back camera found!');
                                }
                            }
                        });
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                    alert(e);
                });
            });
        });
    </script>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
@endpush
