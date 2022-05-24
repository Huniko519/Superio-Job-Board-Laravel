<!-- Filter Block -->
@foreach ($attributes as $attribute)
    <div class="form-group v3_conpany_size">
        <select class="chosen-select">
            <option>{{ __("Company Size") }}</option>
            @foreach($attribute->terms as $term)
                <option @if($term->id == Request::query('team_size')) selected @endif value="{{$term->id}}">{{$term->name}}</option>
            @endforeach
        </select>
    </div>
@endforeach
