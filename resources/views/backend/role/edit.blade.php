<form method="post" act-on="submit" act-request="{{ route('role.update', ['role' => $role->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Role') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $role->name }}"  required   class="form-control">
 
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