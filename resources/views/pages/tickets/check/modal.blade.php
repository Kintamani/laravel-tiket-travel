<!-- Add Modal -->
<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-tool pull-left button-close" data-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
                <h4 class="modal-title">Buy Ticket</h4>
            </div>
            <form action="{{ route('tickets.payment') }}" method="POST" id="payment-form">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="validation-error"></div>
                        <div class="alert alert-danger d-none" id="validation-error-seat"></div>
                        <div class="alert alert-danger d-none" id="validation-error-empty"></div>
                        <input type="hidden" id="schedule-id" name="schedule_id">
                        <input type="hidden" id="available-seats" name="available_seats">
                        <input type="hidden" id="price" name="price">

                        <div class="mb-3">
                            <label for="passenger-name" class="form-label">Passenger Name</label>
                            <input type="input" name="passenger_name" id="passenger-name" class="form-control" value="">
                        </div>
        
                        <div class="mb-3">
                            <label for="seats_purchased" class="form-label">Seats Purchesed</label>
                            <input type="number" name="seats_purchased" id="seats-purchased" class="form-control" value="">
                        </div>
        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01" value="">
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
