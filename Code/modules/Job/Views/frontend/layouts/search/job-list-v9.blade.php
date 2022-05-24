<!-- Listing Section -->
<section class="ls-section map-layout">
    <div class="filters-backdrop"></div>

    <div class="ls-cotainer">
        <!-- Filters Column -->
        <div class="filters-column hide-left">
            <div class="inner-column">
                <div class="filters-outer">
                    <button type="button" class="theme-btn close-filters">X</button>

                    @include("Job::frontend.layouts.form-search.form-style-1")

                </div>
            </div>
        </div>

        <!-- Map Column -->
        <div class="map-column width-50">
            <div id="bc_results_map" class="bc-map">
                <!-- map goes here -->
            </div>
        </div>


        <!-- Content Column -->
        <div class="content-column width-50">
            <div class="ls-outer">
                @if(!empty($rows) && count($rows) > 0)
                    <!-- ls Switcher -->
                    <div class="ls-switcher">
                        <div class="showing-result show-filters">
                            <button type="button" class="theme-btn toggle-filters"><span class="icon icon-filter"></span> {{ __("Filter") }}</button>
                        </div>
                        <div class="sort-by">
                            @include("Job::frontend.layouts.search.order-sort")
                        </div>
                    </div>

                    <div class="row">
                        @foreach($rows as $row)
                            <div class="job-block col-lg-12 col-md-12 col-sm-12">
                                @include("Job::frontend.layouts.loop.job-item-1")
                            </div>
                        @endforeach
                    </div>

                    <!-- Listing pagination -->
                    <div class="ls-pagination">
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                @else
                    <div class="ls-switcher">
                        <div class="showing-result show-filters">
                            <button type="button" class="theme-btn toggle-filters"><span class="icon icon-filter"></span> {{ __("Filter") }}</button>
                        </div>
                    </div>
                    <div class="job-results-not-found">
                        <h3>{{ __("No job results found") }}</h3>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
<!--End Listing Page Section -->
