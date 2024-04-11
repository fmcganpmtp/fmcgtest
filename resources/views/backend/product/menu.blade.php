<option selected disabled value=""></option>
@if($menu)
    @foreach($menu as $option)
    <option value="{{$option->id}}">{{$option->name}}</option>
    @endforeach
@endif