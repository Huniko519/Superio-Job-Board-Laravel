<!-- Checkboxes Ouer -->
<div class="checkbox-outer">
    <h4>{{ $val['title'] }}</h4>
    <ul class="checkboxes square">
        <li>
            <input id="check-b0" type="checkbox" name="experience_year[]" value="fresh" @if(!empty($experience = request()->get('experience_year')) && in_array('fresh', $experience)) checked @endif>
            <label for="check-b0">{{ __("Fresh") }}</label>
        </li>
        <li>
            <input id="check-b1" type="checkbox" name="experience_year[]" value="1" @if(!empty($experience = request()->get('experience_year')) && in_array('1', $experience)) checked @endif>
            <label for="check-b1">{{ __("1 Year") }}</label>
        </li>
        <li>
            <input id="check-b2" type="checkbox" name="experience_year[]" value="2" @if(!empty($experience = request()->get('experience_year')) && in_array('2', $experience)) checked @endif>
            <label for="check-b2">{{ __("2 Years") }}</label>
        </li>
        <li>
            <input id="check-b3" type="checkbox" name="experience_year[]" value="3" @if(!empty($experience = request()->get('experience_year')) && in_array('3', $experience)) checked @endif>
            <label for="check-b3">{{ __("3 Years") }}</label>
        </li>
        <li>
            <input id="check-b4" type="checkbox" name="experience_year[]" value="4" @if(!empty($experience = request()->get('experience_year')) && in_array('4', $experience)) checked @endif>
            <label for="check-b4">{{ __("4 Years") }}</label>
        </li>
        <li class="tg d-none">
            <input id="check-b5" type="checkbox" name="experience_year[]" value="5" @if(!empty($experience = request()->get('experience_year')) && in_array('5', $experience)) checked @endif>
            <label for="check-b5">{{ __("5 Years") }}</label>
        </li>
        <li>
            <button class="view-more" type="button"><span class="icon flaticon-plus"></span>
                <span class="tg-text">{{ __("View More") }}</span>
                <span class="tg-text d-none">{{ __("Show Less") }}</span>
            </button>
        </li>
    </ul>
</div>
