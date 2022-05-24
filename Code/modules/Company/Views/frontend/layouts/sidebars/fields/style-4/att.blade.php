<!-- Filter Block -->
@php
    $selected = (array) Request::query('terms');
@endphp
@foreach ($attributes as $attribute)
    @php $attribute_trans = $attribute->translateOrOrigin(app()->getLocale()); @endphp
    <div class="form-group">
        <select class="chosen-select" name="terms[]" onchange="this.form.submit()">
            <option value="">{{ $attribute_trans->name }}</option>
            @foreach($attribute->terms as $term)
                @php $translate = $term->translateOrOrigin(app()->getLocale()); @endphp
                <option value="{{ $term->id }}" @if(in_array($term->id,$selected)) selected @endif  >{{ $translate->name }}</option>
            @endforeach
        </select>
    </div>
@endforeach
