<!-- Filter Block -->
@if(!empty($min_max_price[1]))
    <div class="filter-block">
        <h4>{{ $val['title'] }}</h4>

        <div class="range-slider-one salary-range">
            <input type="hidden" name="amount_from" value="{{ request()->get('amount_from') ?? $min_max_price[0] }}">
            <input type="hidden" name="amount_to" value="{{ request()->get('amount_to') ?? $min_max_price[1] }}">
            <div class="job-salary-range-slider"></div>
            <div class="input-outer">
                <div class="amount-outer">
                    <span class="amount job-salary-amount">
                        <span class="min">0</span>
                        <span class="max">0</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endif
