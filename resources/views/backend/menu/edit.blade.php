<form method="post" act-on="submit" act-request="{{ route('menu.update', ['menu' => $menu->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Menu') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{ __('Business Category') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="business_category_id" required class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach ($businessCategories as $businessCategory)
                                @if ($businessCategory->id == $menu->business_category_id)
                                    <option value="{{ $businessCategory->id }}" selected>{{ $businessCategory->title }}</option>
                                @else
                                    <option value="{{ $businessCategory->id }}">{{ $businessCategory->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $menu->name }}" required class="form-control">

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>{{ __('Image') }} </label>
                        <div>
                            <div class="custom-file">
                                <input type="file" id="edit-form-image" class="custom-file-input" name="image" hidden accept="image/*">
                                <div class="preview">
                                    @if ($menu->image == '')
                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150" />
                                    @else
                                        <img src="{{ asset('uploads/' . $menu->image) }}" class="img-thumbnail custom-file-preview" width="150" />
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
                            <option value="show" @if ($menu->status == 'show') selected @endif>Show</option>
                            <option value="hide" @if ($menu->status == 'hide') selected @endif>Hide</option>
                        </select>
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
