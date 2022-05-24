<form method="get" action="{{ request()->fullUrl() }}">
    <div class="row">
        @php
            $job_banner_search_fields = setting_item_array('job_banner_search_fields');
            $job_banner_search_fields = array_values(\Illuminate\Support\Arr::sort($job_banner_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
        @endphp
        @if($job_banner_search_fields)
            @foreach($job_banner_search_fields as $key => $val)
                @include("Job::frontend.layouts.form-search.fields.form-banner-1." . $val['type'])
            @endforeach
        @endif
        <!-- Form Group -->
        <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
            @if(isset($_GET['_layout']))
                <input type="hidden" name="_layout" value="{{ $_GET['_layout'] }}">
            @endif
            <button type="submit" class="theme-btn btn-style-one">{{ __("Find Jobs") }}</button>
        </div>
    </div>
</form>
