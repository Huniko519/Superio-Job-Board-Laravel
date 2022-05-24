<form method="get" >
    <input type="hidden" name="_layout" value="{{$layout}}" />
    @php
        $candidate_sidebar_search_fields = setting_item_array('candidate_sidebar_search_fields');
        $candidate_sidebar_search_fields = array_values(\Illuminate\Support\Arr::sort($candidate_sidebar_search_fields, function ($value) {
            return $value['position'] ?? 0;
        }));
    @endphp
    @if($candidate_sidebar_search_fields)
        @foreach($candidate_sidebar_search_fields as $key => $val)
            @php $val['title'] = $val['title_'.app()->getLocale()] ?? $val['title'] ?? "" @endphp
            @include("Candidate::frontend.layouts.sidebars.fields." . $val['type'])
        @endforeach
    @endif
    <div class="wrapper-submit flex-middle col-xs-12 col-md-12">
        <button type="submit" class="theme-btn btn-style-one bg-blue">{{ __("Find Candidates") }}</button>
    </div>
</form>
