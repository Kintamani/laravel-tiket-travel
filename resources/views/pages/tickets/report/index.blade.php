@extends('components.layouts.index')

@section('breadcrumb')
    <div class="col-sm-6">
        <h3 class="mb-0">Report</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tickets.report') }}">Report</a></li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <div class="card-title">Table Report</div>
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
                            <td>Total Seats Purchesed</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->schedule->pickup->name }}</td>
                                <td>{{ $data->schedule->arrival_time }}</td>
                                <td>{{ $data->schedule->destination->name }}</td>
                                <td>{{ $data->schedule->departure_time }}</td>
                                <td>{{ $data->schedule->available_seats }}</td>
                                <td>{{ $data->total_seats_purchased }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
        });
    </script>
@endsection
