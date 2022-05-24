<div class="inner-column pd-right">
    <form method="GET" action="{{ route('companies.index') }}" class="filters-outer search-company bravo_form_filter">
        <button type="button" class="theme-btn close-filters">X</button>
        @if(Request::query('_layout'))
            <input type="hidden" name="_layout" value="{{ Request::query('_layout') }}">
        @endif
        @php
            $company_sidebar_search_fields = setting_item_array('company_sidebar_search_fields');
            $company_sidebar_search_fields = array_values(\Illuminate\Support\Arr::sort($company_sidebar_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
        @endphp
        @if($company_sidebar_search_fields)
            @foreach($company_sidebar_search_fields as $key => $val)
                @php $val['title'] = $val['title_'.app()->getLocale()] ?? $val['title'] ?? "" @endphp
                @include("Company::frontend.layouts.sidebars.fields.style-1." . $val['type'])
            @endforeach
        @endif
        <div class="filter-block submit-filter">
            <button class="btn-submit theme-btn btn-style-one bg-blue" type="submit">{{__("Find Employers")}}</button>
        </div>
    </form>
    <!-- Call To Action -->
    @php
        $company_sidebar_cta = setting_item_with_lang('company_sidebar_cta',request()->query('lang'), $settings['company_sidebar_cta'] ?? false);
        if(!empty($company_sidebar_cta)) $company_sidebar_cta = json_decode($company_sidebar_cta);
    @endphp
    @if(!empty($company_sidebar_cta->title))
        <div class="call-to-action-four">
            <h5>{{ $company_sidebar_cta->title ?? '' }}</h5>
            <p>{{ $company_sidebar_cta->desc ?? '' }}</p>
            @if(!empty($company_sidebar_cta->button->url))
                <a href="{{ ($company_sidebar_cta->button->url) }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">{{ $company_sidebar_cta->button->name ?? __("Start Recruiting Now") }}</span></a>
            @endif
            <div class="image" style="background-image: url({{ !empty($company_sidebar_cta->image) ? \Modules\Media\Helpers\FileHelper::url($company_sidebar_cta->image, 'full') : '' }});"></div>
        </div>
    @endif
    <!-- End Call To Action -->
</div>
@section('footer')
    <script>
        @if(!empty(Request::query('from_date')) && !empty(Request::query('to_date')))
            $(document).on('ready', function () {
                var range_from = '{{ Request::query('from_date') }}';
                var range_to = '{{ Request::query('to_date') }}';
                $(".range-slider-one .range-slider").slider('values',0,range_from);
                $(".range-slider-one .range-slider").slider('values',1,range_to);
                $( ".range-slider-one .count" ).text( range_from + " - " + range_to );
            });
        @endif
    </script>
@endsection
