<!--Page Title-->
<section class="page-title">
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
                        <div class="ls-switcher">
                            <div class="showing-result show-filters">
                                <button type="button" class="theme-btn toggle-filters"><span class="icon icon-filter"></span> {{ __("Filter") }}</button>
                            </div>
                        </div>
                        <div class="job-results-not-found mb-5 text-center">
                            <h3>{{ __("No job results found") }}</h3>
                        </div>
                    @endif

                    @php
                        $job_sidebar_cta = setting_item_with_lang('job_sidebar_cta',request()->query('lang'), $settings['job_sidebar_cta'] ?? false);
                        if(!empty($job_sidebar_cta)) $job_sidebar_cta = json_decode($job_sidebar_cta);
                    @endphp
                    @if(!empty($job_sidebar_cta->title))
                        <!-- Call To Action -->
                        <div class="call-to-action-four style-two">
                            <h5>{{ $job_sidebar_cta->title ?? '' }}</h5>
                            <p>{{ $job_sidebar_cta->desc ?? '' }}</p>
                            @if(!empty($job_sidebar_cta->button->url))
                                <a href="{{ ($job_sidebar_cta->button->url) }}" target="{{ $job_sidebar_cta->button->target ?? "_self" }}" class="theme-btn btn-style-one bg-blue">
                                    <span class="btn-title">{{ $job_sidebar_cta->button->name ?? __("Start Recruiting Now") }}</span>
                                </a>
                            @endif
                            <div class="image" style="background-image: url({{ !empty($job_sidebar_cta->image) ? \Modules\Media\Helpers\FileHelper::url($job_sidebar_cta->image, 'full') : '' }});"></div>
                        </div>
                        <!-- End Call To Action -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Listing Page Section -->
