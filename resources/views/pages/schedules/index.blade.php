@extends('components.layouts.index')

@section('breadcrumb')
    <div class="col-sm-6">
        <h3 class="mb-0">Schedules</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}">Schedules</a></li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <div class="card-title">Table Schedules</div>
            <button type="button" class="btn btn-primary btn-sm btn-add float-end">
                Create Schedule <i class="nav-icon bi bi-plus"></i>
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%"cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%">No</td>
                            <td>Pickup Location</td>
                            <td>Arrival Time</td>
                            <td>Destination Location</td>
                            <td>Departure Time</td>
                            <td>Available Seats</td>
                            <td>Price</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->pickup->name }}</td>
                                <td>{{ $data->arrival_time }}</td>
                                <td>{{ $data->destination->name }}</td>
                                <td>{{ $data->departure_time }}</td>
                                <td>{{ $data->available_seats }}</td>
                                <td>{{ $data->price }}</td>
                                <td>
                                    <form action="{{ route('schedules.destroy', $data->id) }}" method="POST">
                                        @csrf @method('delete')
                                        <a href="javascript:void()" class="btn btn-warning btn-sm btn-circle btn-edit"
                                            data-id="{{ $data->id }}" 
                                            data-pickup-id="{{ $data->pickup->id }}" 
                                            data-destination-id="{{ $data->destination->id }}" 
                                            data-description="{{ $data->description }}" 
                                            data-departure-time="{{ $data->departure_time }}" 
                                            data-arrival-time="{{ $data->arrival_time }}" 
                                            data-available-seats="{{ $data->available_seats }}" 
                                            data-price="{{ $data->price }}"
                                            >
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                            onclick="return confirm('Yakin');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @extends('pages.schedules.modal')
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('#schedule-form').submit(function(event) {
                let pickup = $('#pickup-id').val();
                let destination = $('#destination-id').val();
                let arrivalTime = new Date($('#arrival-time').val());
                let departureTime = new Date($('#departure-time').val());
                let seats = parseInt($('#available-seats').val());
                let errorDiv = $('#validation-error');
                let dateErrorDiv = $('#date-validation-error');
                let hasError = false;

                if (pickup === destination) {
                    errorDiv.removeClass('d-none');
                    hasError = true;
                } else {
                    errorDiv.addClass('d-none');
                }

                if (departureTime <= arrivalTime) {
                    dateErrorDiv.removeClass('d-none');
                    hasError = true;
                } else {
                    dateErrorDiv.addClass('d-none');
                }

                if (seats < 1) {
                    alert("Available seats must be at least 1.");
                    hasError = true;
                }

                if (hasError) {
                    event.preventDefault();
                }
            });
        });

        $('.button-close').click(function() {
            $('#modal').modal('hide');
        });

        $(".btn-add").click(function() {
            $("#modal").modal("show");
            $(".modal-title").html("Create Schedules");
            $("#id").val("");
            $("#pickup-id").val("");
            $("#description").val("");
            $("#destination-id").val("");
            $("#departure-time").val("");
            $("#arrival-time").val("");
            $("#available-seats").val("");
            $("#price").val("");
        });

        $("#dataTable").on("click", ".btn-edit", function() {
            let id = $(this).data("id");
            let pickup_id = $(this).data("pickup-id");
            let destination_id = $(this).data("destination-id");
            let departure_time = $(this).data("departure-time");
            let description = $(this).data("description");
            let arrival_time = $(this).data("arrival-time");
            let available_seats = $(this).data("available-seats");
            let price = $(this).data("price");
            $("#modal").modal("show");
            $(".modal-title").html("Edit Schedules");
            $("#id").val(id);
            $("#pickup-id").val(pickup_id);
            $("#description").val(description);
            $("#destination-id").val(destination_id);
            $("#departure-time").val(departure_time);
            $("#arrival-time").val(arrival_time);
            $("#available-seats").val(available_seats);
            $("#price").val(price);
        });
    </script>
@endsection
