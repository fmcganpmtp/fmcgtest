<form method="post" act-on="submit" act-request="{{ route('home.banner.update', ['homebanner' => $homebanner->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Slider') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">


            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{ __('Image') }} </label>
                    <div>

                        <div>
                            <div class="custom-file">
                                <input type="file" id="edit-form-image" class="custom-file-input" name="image" hidden accept="image/*">
                                <div class="preview">
                                    @if ($homebanner->image == '')
                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150" />
                                    @else
                                        <img src="{{ asset('uploads/' . $homebanner->image) }}" class="img-thumbnail custom-file-preview" width="150" />
                                    @endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                        <div>
                            <select name="status" required class="form-select select2">
                                <option value="show" @if ($homebanner->status == 'show') selected @endif>Show</option>
                                <option value="hide" @if ($homebanner->status == 'hide') selected @endif>Hide</option>
                            </select>
                        </div>
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
