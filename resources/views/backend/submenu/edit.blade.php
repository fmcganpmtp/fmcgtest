<form method="post" act-on="submit" act-request="{{ route('submenu.update', ['submenu' => $submenu->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Submenu') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Business Category') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="business_category_id" required class="form-select select2" act-on="change" act-request="{{ route('product.menu') }}">
                            <option disabled selected value=""></option>
                            @foreach ($businessCategories as $businessCategory)
                                <option value="{{ $businessCategory->id }}" @if ($sel_business_category->id == $businessCategory->id) selected @endif>{{ $businessCategory->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Menu Name') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="menu_id" id="menu"  class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" @if ($submenu->menu_id == $menu->id) selected @endif>{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Menu Name') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="menu_id" required class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach($menu as $menu)

                                @if($menu->id == $submenu->menu_id)
                                <option value="{{$menu->id}}" selected>{{$menu->name}}</option>
                                @else
                                <option value="{{$menu->id}}">{{$menu->name}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $submenu->name }}"  required   class="form-control">

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
                                    @if ($submenu->image == '')
                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150" />
                                    @else
                                        <img src="{{ asset('uploads/' . $submenu->image) }}" class="img-thumbnail custom-file-preview" width="150" />
                                    @endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                    <div>
                        <select name="status" required class="form-select select2">
                            <option value="show" @if($submenu->status == 'show') selected @endif >Show</option>
                            <option value="hide" @if($submenu->status == 'hide') selected @endif >Hide</option>
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
