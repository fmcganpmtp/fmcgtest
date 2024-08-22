<form method="post" act-on="submit" act-request="{{ route('deliveryslot.update', ['deliveryslot' => $deliveryslot->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit delivery Slot') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Slot Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="slot_name" value="{{ $deliveryslot->slot_name }}"  required   class="form-control">

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Start Time') }} </label>
                    <div>
                        <input type="time" name="start" value="{{ $deliveryslot->start }}"   class="form-control">

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('End Time') }} </label>
                    <div>
                        <input type="time" name="end" value="{{ $deliveryslot->end }}"   class="form-control">

                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary waves-effect mr-2 px-3">
            Cancel
        </button>
        <button type="submit" disabled="disabled" class="btn btn-primary waves-effect waves-light mr-2 px-3">
            Update
        </button>
    </div>
</form>
