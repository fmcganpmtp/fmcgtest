<form method="post" act-on="submit" act-request="{{ route('user.update', ['user' => $user->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit User') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $user->name }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
 
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Role') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="role_id" required class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach($roles as $role)
                                
                                @if($role->id == $user->role_id)
                                <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                @else
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                            
                            @endforeach
                        </select>                                           
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Mobile Number') }} </label>
                    <div>
                        <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control">
                    </div>
                </div>
            </div>
 

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Email') }} </label>
                    <div>
                        <input type="text" name="email" value="{{ $user->email }}"   class="form-control input-mask" data-inputmask="'alias': 'email'">
                    </div>
                </div>
            </div>



            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Password') }} </label>
                    <div>
                        <input type="text" name="password" class="form-control">
 
                    </div>
                </div>
            </div>
 
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                    <div>
                        <select name="status" required class="form-select select2">
                            <option value="active" @if($user->status == 'active') selected @endif >Active</option>
                            <option value="blocked" @if($user->status == 'blocked') selected @endif >Blocked</option>
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