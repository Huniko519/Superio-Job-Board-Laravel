<section class="ls-section style-two">
    <div class="filters-backdrop"></div>

    <div class="row no-gutters">
        <!-- Filters Column -->
        <div class="filters-column col-xl-3 col-lg-4 col-md-12 col-sm-12">
            <div class="inner-column">
                <div class="filters-outer">
                    <button type="button" class="theme-btn close-filters">X</button>

                    @include("Job::frontend.layouts.form-search.form-style-1")

                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="content-column col-xl-9 col-lg-8 col-md-12 col-sm-12">
            <div class="ls-outer">
                <button type="button" class="theme-btn btn-style-two toggle-filters">{{ __("Show Filters") }}</button>

                @if(!empty($rows) && count($rows) > 0)
                    <!-- ls Switcher -->
                    <div class="ls-switcher">
                        <div class="showing-result">
                            <div class="text">{{ __("Showing") }} <strong>{{ $rows->firstItem() }}-{{ $rows->lastItem() }}</strong> {{ __("of") }} <strong>{{ $rows->total() }}</strong> {{ __("jobs") }}</div>
                        </div>
                        <div class="sort-by">
                            <form class="bc-form-order" method="get" action="{{ route('job.search') }}">
                                @include("Job::frontend.layouts.search.order-sort")
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($rows as $row)
                            <div class="job-block col-lg-6 col-md-12 col-sm-12">
                                @include("Job::frontend.layouts.loop.job-item-1")
                            </div>
                        @endforeach
                    </div>

                    <!-- Listing pagination -->
                    <div class="ls-pagination">
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                @else
                    <div class="job-results-not-found">
                        <h3>{{ __("No job results found") }}</h3>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
