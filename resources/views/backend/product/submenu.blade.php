<option selected disabled value=""></option>
@if($submenu)
    @foreach($submenu as $option)
    <option value="{{$option->id}}">{{$option->name}}</option>
    @endforeach
@endif