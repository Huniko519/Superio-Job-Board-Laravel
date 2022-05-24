<!-- ls Switcher -->
<form class="bc-form-order" method="get">
<div class="ls-switcher">
        <div class="showing-result">
            <div class="top-filters">
                <div class="form-group">
                    <select class="chosen-select" name="delivery_time" onchange="this.form.submit()">
                        <option value="">{{ __("Delivery Time") }}</option>
                        <option @if(request()->input('delivery_time') == '1') selected @endif value="1">{{ __("Express 24H") }}</option>
                        <option @if(request()->input('delivery_time') == '3') selected @endif value="3">{{ __("Up to 3 days") }}</option>
                        <option @if(request()->input('delivery_time') == '7') selected @endif value="7">{{ __("Up to 7 days") }}</option>
                        <option @if(request()->input('delivery_time') == 'any_time') selected @endif value="any_time">{{__("Anytime")}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="chosen-container chosen-container-single chosen-container-single-nosearch">
                        <button type="button" class="chosen-single dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __("Budget") }}
                            <div><b></b></div>
                        </button>
                        <div class="dropdown-menu">
                            <div class="ml-3 mr-3" style="width: 300px">
                                <div class="">
                                    <lable>
                                        {{ __("Min.") }} - {{ __("Max.") }}
                                    </lable>
                                    <div class="range-slider-one salary-range">
                                        <input type="hidden" name="amount_from" value="{{ request()->get('amount_from') ?? $min_max_price[0] }}">
                                        <input type="hidden" name="amount_to" value="{{ request()->get('amount_to') ?? $min_max_price[1] }}">
                                        <div class="job-salary-range-slider"
                                             data-min="{{ $min_max_price[0] }}"
                                             data-max="{{ $min_max_price[1] }}"
                                             data-from="{{ request()->get('amount_from') ?? $min_max_price[0] }}"
                                             data-to="{{ request()->get('amount_to') ?? $min_max_price[1] }}"
                                        ></div>
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
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="text-right ml-4 mr-4"> <button type="submit" class="btn btn-info btn-sm"> {{ __("Apply") }} </button> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sort-by">
            <select class="chosen-select" name="orderby" onchange="this.form.submit()">
                <option value="">{{__('Sort by (Default)')}}</option>
                <option value="new" @if(request()->get('orderby') == 'new') selected @endif>{{__('Newest')}}</option>
                <option value="old" @if(request()->get('orderby') == 'old') selected @endif>{{__('Oldest')}}</option>
                <option value="name_high" @if(request()->get('orderby') == 'name_high') selected @endif>{{__('Name [a->z]')}}</option>
                <option value="name_low" @if(request()->get('orderby') == 'name_low') selected @endif>{{__('Name [z->a]')}}</option>
            </select>
        </div>

</div>
</form>
@if($rows->isNotEmpty())
    <div class="ls-switcher">
        <div class="showing-result">
            <div class="text">{{__('Showing')}} <strong>{{$rows->firstItem()}}-{{$rows->lastItem()}}</strong> {{__('of')}} <strong>{{$rows->total()}}</strong>
                {{__('items')}}</div>
        </div>
    </div>
@endif
