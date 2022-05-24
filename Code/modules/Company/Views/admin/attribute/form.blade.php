<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$translation->name}}" placeholder="{{__("Attribute name")}}" name="name" class="form-control">
</div>
@if(is_default_lang())
    <div class="form-group">
        <label>{{__("Position Order")}}</label>
        <input type="number" min="0" value="{{$row->position}}" placeholder="{{__("Ex: 1")}}" name="position" class="form-control">
        <small>
            {{ __("The position will be used to order in the Filter page search. The greater number is priority") }}
        </small>
    </div>
@endif
