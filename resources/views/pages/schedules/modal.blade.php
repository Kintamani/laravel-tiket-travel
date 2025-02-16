<!-- Add Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-tool pull-left button-close" data-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
                <h4 class="modal-title">Create Schedules</h4>
            </div>
            <form action="{{ route('schedules.store') }}" method="POST" id="schedule-form">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="validation-error">Pickup location and destination must be different.</div>
                        <div class="alert alert-danger d-none" id="date-validation-error">Departure time must be after arrival time.</div>
                        <input type="hidden" id="id" name="id">

                        <div class="mb-3">
                            <label for="pickup_id" class="form-label">Pickup Location</label>
                            <select name="pickup_id" id="pickup-id" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ isset($schedule) && $schedule->pickup_id == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="mb-3">
                            <label for="arrival_time" class="form-label">Arrival Time</label>
                            <input type="datetime-local" name="arrival_time" id="arrival-time" class="form-control" value="{{ isset($schedule) ? $schedule->arrival_time : old('arrival_time') }}">
                        </div>
        
                        <div class="mb-3">
                            <label for="destination_id" class="form-label">Destination</label>
                            <select name="destination_id" id="destination-id" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ isset($schedule) && $schedule->destination_id == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="mb-3">
                            <label for="departure_time" class="form-label">Departure Time</label>
                            <input type="datetime-local" name="departure_time" id="departure-time" class="form-control" value="{{ isset($schedule) ? $schedule->departure_time : old('departure_time') }}">
                        </div>
        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ isset($schedule) ? $schedule->description : old('description') }}</textarea>
                        </div>
        
                        <div class="mb-3">
                            <label for="available_seats" class="form-label">Available Seats</label>
                            <input type="number" name="available_seats" id="available-seats" class="form-control" value="{{ isset($schedule) ? $schedule->available_seats : old('available_seats') }}">
                        </div>
        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ isset($schedule) ? $schedule->price : old('price') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left button-close"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
