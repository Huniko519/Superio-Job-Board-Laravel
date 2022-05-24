<!--Page Title-->
<section class="page-title">
    <div class="auto-container">
        <!-- Job Search Form -->
        <form method="GET" action="{{ route('companies.index') }}">
            @if(Request::query('_layout'))
                <input type="hidden" name="_layout" value="{{ Request::query('_layout') }}">
            @endif
            <div class="company-search-form">
                <div class="row">
                    <!-- Form Group -->
                @include("Company::frontend.layouts.sidebars.fields.style-3.keyword")
                <!-- Form Group -->
                @include("Company::frontend.layouts.sidebars.fields.style-3.location")
                <!-- Form Group -->
                @include("Company::frontend.layouts.sidebars.fields.style-3.category")
                <!-- Form Group -->
                    <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                        <button type="submit" class="theme-btn btn-style-one">{{__("Find Employers")}}</button>
                    </div>
                </div>
            </div>
            <!-- Job Search Form -->
            <div class="top-filters">
                @include("Company::frontend.layouts.sidebars.fields.style-3.team_size")
                @include("Company::frontend.layouts.sidebars.fields.style-3.founded_date")
            </div>
        </form>
    </div>
</section>
<!--End Page Title-->
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
                        <div class="showing-result">
                            <div class="text">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
                        </div>
                        @include('Company::frontend.layouts.search.company-sort')
                    </div>
                    <!-- Block Block -->
                    @if($rows->count() > 0)
                        <div class="row">
                            @foreach($rows as $row)
                                @include('Company::frontend.layouts.loop.company-item-3')
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
            $(".range-slider-one .range-slider").slider('values',0,range_from);
            $(".range-slider-one .range-slider").slider('values',1,range_to);
            $( ".range-slider-one .count" ).text( range_from + " - " + range_to );
        });
        @endif
    </script>
@endsection
