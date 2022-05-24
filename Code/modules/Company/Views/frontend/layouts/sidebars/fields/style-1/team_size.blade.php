<!-- Filter Block -->
@php
    $selected = (array) Request::query('terms');
@endphp
@foreach ($attributes as $attribute)
    <div class="filter-block checkbox-outer">
        @php $attribute_trans = $attribute->translateOrOrigin(app()->getLocale());@endphp
        <h4>{{ $attribute_trans->name }}</h4>
        <ul class="checkboxes square">
            @foreach($attribute->terms as $term)
                @php $translate = $term->translateOrOrigin(app()->getLocale()); @endphp
                <li>
                    <input id="check-{{$term->id}}" type="checkbox" name="terms[]" value="{{ $term->id }}" @if(in_array($term->id,$selected)) checked @endif>
                    <label for="check-{{$term->id}}">{{$translate->name}}</label>
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
