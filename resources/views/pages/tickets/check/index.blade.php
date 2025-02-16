@extends('components.layouts.index')

@section('breadcrumb')
    <div class="col-sm-6">
        <h3 class="mb-0">Available Tickets</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tickets.available') }}">Tickets</a></li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4 mb-3 px-3">
            <div class="alert alert-danger d-none" id="validation-error">Pickup location and destination must be different.
            </div>
            <div class="alert alert-danger d-none" id="empty-fields-error">All fields are required.</div>
            <div class="card border-left-danger shadow py-2">
                <form action="{{ route('tickets.check') }}" method="POST" id="ticket-form">
                    @csrf
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="pickup_id" class="form-label">Pickup Location</label>
                                        <select name="pickup_id" id="pickup-id" class="form-control">
                                            <option value="">-</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ isset($pickup_id) && $pickup_id == $location->id ? 'selected' : '' }}>
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="arrival_time" class="form-label">Arrival Time</label>
                                        <input type="date" name="arrival_time" id="arrival-time" class="form-control"
                                            value="{{ isset($arrival_time) ? $arrival_time : old('arrival_time', now()->format('Y-m-d H:i')) }}">
                                    </div>

                                    <div class="col-4">
                                        <label for="destination_id" class="form-label">Destination</label>
                                        <select name="destination_id" id="destination-id" class="form-control">
                                            <option value="">-</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ isset($destination_id) && $destination_id == $location->id ? 'selected' : '' }}>
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-8 mb-3 px-3">
            <div class="row">
                @forelse ($schedules as $schedule)
                    <div class="col-sm-6">
                        <div class="small-box text-bg-primary ">
                            <div class="row">
                                <div class="col-6 p-4">
                                    <div class="inner px-3">
                                        <h3>{{ $schedule->remaining_seats }}</h3>
                                        <p class="my-0">Available Tickets</p>
                                        <p>Destination: {{ $schedule->destination->name }}</p>
                                    </div>
                                </div>
                                <div class="col-6 p-4">
                                    <div class="inner px-3">
                                        <h3>@money($schedule->price)</h3>
                                    </div>
                                </div>
                                <div class="col-8 p-3">
                                    <div class="inner px-3">
                                        <h5>{{ $schedule->arrival_time }}</h5>
                                        <p>Arrival Time</p>
                                    </div>
                                </div>
                            </div>

                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M19 17h2l.64-2.54a6 6 0 000-2.92l-1.07-4.27A3 3 0 0017.66 5H4a2 2 0 00-2 2v10h2m10 0h-4" />
                                <circle cx="6.5" cy="17.5" r="2.5" />
                                <circle cx="16.5" cy="17.5" r="2.5" />
                            </svg>
                            <a href="javascript:void()"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover btn-payment"
                                data-id = "{{ $schedule->id }}" data-available_seats = "{{ $schedule->remaining_seats }}"
                                data-price = "{{ $schedule->price }}">
                                Buy Ticket <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-sm-12 text-center">
                        <div class="card card-primary ">
                            <div class="card-body">
                                <h2 class="card-title">No Available Tickets</h2>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @extends('pages.tickets.check.modal')
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#ticket-form').submit(function(event) {
                let pickup = $('#pickup-id').val();
                let destination = $('#destination-id').val();
                let arrivalTime = $('#arrival-time').val();
                let errorDiv = $('#validation-error');
                let emptyFieldsError = $('#empty-fields-error');
                let hasError = false;

                if (!pickup || !destination || !arrivalTime) {
                    emptyFieldsError.removeClass('d-none');
                    hasError = true;
                } else {
                    emptyFieldsError.addClass('d-none');
                }

                if (pickup === destination) {
                    errorDiv.removeClass('d-none');
                    hasError = true;
                } else {
                    errorDiv.addClass('d-none');
                }

                if (hasError) {
                    event.preventDefault();
                }
            });

            $('#payment-form').submit(function(event) {
                let pickup = $('#schedule-id').val();
                let available_seats = $('#available-seats').val();
                let seats_purchased = $('#seats-purchased').val();
                let amount = $('#amount').val();
                let price = $('#price').val();

                let errorDiv = $('#validation-error');
                let validationErrorSeat = $('#validation-error-seat');
                let emptyFieldsError = $('#validation-error-empty');
                let hasError = false;

                // Validasi jika ada field yang kosong
                if (!pickup || isNaN(available_seats) || isNaN(seats_purchased) || isNaN(amount) || isNaN(price)) {
                    emptyFieldsError.removeClass('d-none').text(
                        'All fields are required.');
                    hasError = true;
                } else {
                    emptyFieldsError.addClass('d-none');
                }

                if (seats_purchased > available_seats || seats_purchased <= 0) {
                    validationErrorSeat.removeClass('d-none').text(
                        'Seats purchased cannot be more than available seats or less than 1.');
                    hasError = true;
                } else {
                    validationErrorSeat.addClass('d-none');
                }

                let requiredAmount = price * seats_purchased;
                if (amount < requiredAmount) {
                    errorDiv.removeClass('d-none').text(
                        `Amount must be at least ${requiredAmount.toFixed(2)}`);
                    hasError = true;
                } else {
                    errorDiv.addClass('d-none');
                }

                if (hasError) {
                    event.preventDefault();
                }
            });
        });

        $(".btn-payment").click(function() {
            let id = $(this).data("id");
            let available_seats = $(this).data("available_seats");
            let price = $(this).data("price");
            $("#modal-payment").modal("show");
            $(".modal-title").html("Ticket Payment");
            $("#schedule-id").val(id);
            $("#available-seats").val(available_seats);
            $("#price").val(price);
        });
    </script>
@endsection
