@extends('components.layouts.index')

@section('breadcrumb')
    <div class="col-sm-6">
        <h3 class="mb-0">History Tickets</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tickets.history') }}">History Tickets</a></li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4 mb-3 px-3">
            <div class="alert alert-danger d-none" id="validation-error">Pickup location and destination must be different.
            </div>
            <div class="card border-left-danger shadow py-2">
                <form action="{{ route('tickets.history.find') }}" method="POST" id="ticket-form">
                    @csrf
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="row">
                                    <div class="col-12">
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
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Table History Tickets</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover" id="dataTable"
                        width="100%"cellspacing="0">
                        <thead>
                            <tr>
                                <td width="5%">No</td>
                                <td>Destination Location</td>
                                <td>Departure Time</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->schedule->destination->name }}</td>
                                    <td>{{ $data->schedule->departure_time }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        <a href="{{ route('tickets.invoice', $data->id) }}" class="btn btn-warning btn-sm btn-circle btn-invoice"
                                            data-id="{{ $data->id }}">
                                            Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
