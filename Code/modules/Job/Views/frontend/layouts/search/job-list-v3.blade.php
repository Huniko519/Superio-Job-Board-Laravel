<!--Page Title-->
<section class="page-title">
    <div class="auto-container">
        <div class="title-outer">
            <h1>{{ setting_item_with_lang('job_page_search_title') ?? __("Find Jobs") }}</h1>
            <ul class="page-breadcrumb">
                <li><a href="{{ home_url() }}">{{ __("Home") }}</a></li>
                <li>{{ __("Jobs") }}</li>
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
            <div class="filters-column col-lg-4 col-md-12 col-sm-12">
                <div class="inner-column">
                    <div class="filters-outer">
                        <button type="button" class="theme-btn close-filters">X</button>
                        @include("Job::frontend.layouts.form-search.form-style-1")
                    </div>

                    @php
                        $job_sidebar_cta = setting_item_with_lang('job_sidebar_cta',request()->query('lang'), $settings['job_sidebar_cta'] ?? false);
                        if(!empty($job_sidebar_cta)) $job_sidebar_cta = json_decode($job_sidebar_cta);
                    @endphp
                    @if(!empty($job_sidebar_cta->title))
                        <!-- Call To Action -->
                        <div class="call-to-action-four">
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

            <!-- Content Column -->
            <div class="content-column col-lg-8 col-md-12 col-sm-12">
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
                            <!-- Job Block -->
                            <div class="job-block-four col-lg-6 col-md-6 col-sm-12">
                                @include("Job::frontend.layouts.loop.job-item-4")
                            </div>
                            @endforeach

                            <!-- Listing pagination -->
                            <div class="ls-pagination col-12">
                                {{$rows->appends(request()->query())->links()}}
                            </div>
                        </div>
                    @else
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
