<!-- Checkboxes Ouer -->
<div class="checkbox-outer">
    <h4>{{ $val['title'] }}</h4>
    <ul class="checkboxes">
        <li>
            <input id="check-a1" type="radio" name="date_posted" value="all" @if(request()->get('date_posted') == 'all') checked @endif>
            <label for="check-a1">{{ __("All") }}</label>
        </li>
        <li>
            <input id="check-a" type="radio" name="date_posted" value="last_hour" @if(request()->get('date_posted') == 'last_hour') checked @endif>
            <label for="check-a">{{ __("Last Hour") }}</label>
        </li>
        <li>
            <input id="check-b" type="radio" name="date_posted" value="last_1" @if(request()->get('date_posted') == 'last_1') checked @endif>
            <label for="check-b">{{ __("Last 24 Hours") }}</label>
        </li>
        <li>
            <input id="check-c" type="radio" name="date_posted" value="last_7" @if(request()->get('date_posted') == 'last_7') checked @endif>
            <label for="check-c">{{ __("Last 7 Days") }}</label>
        </li>
        <li>
            <input id="check-d" type="radio" name="date_posted" value="last_14" @if(request()->get('date_posted') == 'last_14') checked @endif>
            <label for="check-d">{{ __("Last 14 Days") }}</label>
        </li>
        <li>
            <input id="check-e" type="radio" name="date_posted" value="last_30" @if(request()->get('date_posted') == 'last_30') checked @endif>
            <label for="check-e">{{ __("Last 30 Days") }}</label>
        </li>
    </ul>
</div>
