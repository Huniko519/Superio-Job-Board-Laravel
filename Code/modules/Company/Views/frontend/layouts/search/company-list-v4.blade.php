<form method="GET" action="{{ route('companies.index') }}">
<div class="listing-maps style-two">
    <div id="map">
        <!-- map goes here -->
    </div>
    <div class="form-outer">
        <div class="auto-container">
            <div class="style-two">
                    @if(Request::query('_layout'))
                        <input type="hidden" name="_layout" value="{{ Request::query('_layout') }}">
                    @endif
                    <div class="company-search-form style-v4">
                        <div class="row">
                            <!-- Form Group -->
                        @include("Company::frontend.layouts.sidebars.fields.style-4.keyword")
                        <!-- Form Group -->
                        @include("Company::frontend.layouts.sidebars.fields.style-4.location")
                        <!-- Form Group -->
                        @include("Company::frontend.layouts.sidebars.fields.style-4.category")

                        <!-- Form Group -->
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                                <button type="submit" class="theme-btn btn-style-three">{{__("Find Employers")}}</button>
                            </div>
                        </div>
                    </div>
                    <!-- Job Search Form -->
            </div>
        </div>
    </div>
</div>
</form>
<!-- Listing Section -->
<section class="ls-section">
    <div class="auto-container">
        <div class="filters-backdrop"></div>
        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12">
                <div class="ls-outer">
                    <button type="button" class="theme-btn btn-style-two toggle-filters">{{__("Show Filters")}}</button>
                    <!-- ls Switcher -->
                    <div class="ls-switcher">
                        <form class="bc-form-order form-style-4" method="get">
                            @if(Request::query('_layout'))
                                <input type="hidden" name="_layout" value="{{ Request::query('_layout') }}">
                            @endif
                                <input type="hidden" name="s" value="{{ Request::query("s") }}">
                                <input type="hidden" name="location" value="{{ Request::query("location") }}">
                                <input type="hidden" name="category" value="{{ Request::query("category") }}">
                            <div class="showing-result">
                                <div class="top-filters">
                                    @include("Company::frontend.layouts.sidebars.fields.style-4.att")
                                    @include("Company::frontend.layouts.sidebars.fields.style-4.founded_date")
                                </div>
                            </div>
                        </form>
                        @include('Company::frontend.layouts.search.company-sort')
                    </div>
                    <!-- Block Block -->
                    @if($rows->count() > 0)
                        <div class="row">
                            @foreach($rows as $row)
                                @include('Company::frontend.layouts.loop.company-item-4')
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-danger">
                            {{__("Sorry, but nothing matched your search terms. Please try again with some different keywords.")}}
                        </div>
                    @endif
                    <div class="bravo-pagination">
                        {{$rows->appends(request()->query())->links()}}
                        @if($rows->total() > 0)
                            <span class="count-string">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Listing Page Section -->
@section('footer')
    <script>
        @if(!empty(Request::query('from_date')) && !empty(Request::query('to_date')))
        $(document).on('ready', function () {
            var range_from = '{{ Request::query('from_date') }}';
            var range_to = '{{ Request::query('to_date') }}';
            $(".range-slider-tyle-4 .range-slider").slider('values',0,range_from);
            $(".range-slider-tyle-4 .range-slider").slider('values',1,range_to);
            $( ".range-slider-tyle-4 .count" ).text( range_from + " - " + range_to );
        });
        @endif
    </script>
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        var bravo_map_data = {
            markers:{!! json_encode($markers) !!},
            center: [{{ !empty($markers[0]['lat']) ? $markers[0]['lat'] : 40.80 }}, {{ !empty($markers[0]['lng']) ? $markers[0]['lng'] : -73.70 }}]
        };
    </script>
    <script type="text/javascript" src="{{ asset('module/company/js/company-map.js?_ver='.config('app.asset_version')) }}"></script>
@endsection
