<!-- Filter Block -->
@if($list_skills)
    <div class="filter-block">
        <h4>{{ $val['title'] }}</h4>
        <div class="form-group">

            <select class="chosen-select" name="skill">
                <option value="">{{ __("Choose a skill") }}</option>
                @foreach($list_skills as $skill)
                    @php
                        $translate = $skill->translateOrOrigin(app()->getLocale());
                    @endphp
                    <option value="{{ $skill->id }}" @if($skill->id == request()->get('skill')) selected @endif  >{{ $translate->name }}</option>
                @endforeach
            </select>
            <span class="icon flaticon-pencil"></span>
        </div>
    </div>
@endif
