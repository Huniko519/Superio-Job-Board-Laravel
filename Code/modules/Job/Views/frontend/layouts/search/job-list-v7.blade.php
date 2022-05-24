<!--Page Title-->
<section class="page-title bg-light">
    <div class="auto-container">
        <div class="title-outer">
            <h1>{{ setting_item_with_lang('job_page_search_title') ?? __("Find Jobs") }}</h1>
            <ul class="page-breadcrumb">
                <ul class="page-breadcrumb">
                    <li><a href="{{ home_url() }}">{{ __("Home") }}</a></li>
                    @if(!empty($category))
                        <li><a href="{{ route("job.search") }}">{{ __("Jobs") }}</a></li>
                        <li>{{ $category->name }}</li>
                    @elseif(!empty($location))
                        <li><a href="{{ route("job.search") }}">{{ __("Jobs") }}</a></li>
                        <li>{{ $location->name }}</li>
                    @else
                        <li>{{ __("Jobs") }}</li>
                    @endif
                </ul>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!-- Listing Section -->
<section class="ls-section">
    <div class="auto-container">
        <div class="filters-backdrop"></div>

        <div class="row">
            <!-- Filters Column -->
            <div class="filters-column hide-left">
                <div class="inner-column">
                    <div class="filters-outer">
                        <button type="button" class="theme-btn close-filters">X</button>

                        @include("Job::frontend.layouts.form-search.form-style-1")

                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="content-column col-lg-12">
                <div class="ls-outer">
                    @if(!empty($rows) && count($rows) > 0)
                        <!-- ls Switcher -->
                        <div class="ls-switcher">
                            <div class="showing-result show-filters">
                                <button type="button" class="theme-btn toggle-filters"><span class="icon icon-filter"></span> {{ __("Filter") }}</button>
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
                                <div class="job-block-four col-lg-4 col-md-6 col-sm-12">
                                    @include("Job::frontend.layouts.loop.job-item-4")
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
    </div>
</section>
<!--End Listing Page Section -->
