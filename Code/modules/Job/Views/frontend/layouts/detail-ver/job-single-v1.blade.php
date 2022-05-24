<!-- Job Detail Section -->
<section class="job-detail-section">

    <!-- Upper Box -->
    <div class="upper-box">
        <div class="auto-container">
            <!-- Job Block -->
            <div class="job-block-seven">
                <div class="inner-box">
                    @include("Job::frontend.layouts.details.upper-box")
                    @include("Job::frontend.layouts.details.apply-button")
                </div>
            </div>
        </div>
    </div>

    <div class="job-detail-outer">
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-8 col-md-12 col-sm-12">

                    <div class="job-detail">
                        {!! @clean($translation->content) !!}
                    </div>

                    @include("Job::frontend.layouts.details.gallery")

                    @include("Job::frontend.layouts.details.video")

                    @include("Job::frontend.layouts.details.social-share")

                    @include("Job::frontend.layouts.details.related")

                </div>

                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">
                        <div class="sidebar-widget">

                            @include("Job::frontend.layouts.details.overview")

                            @if($row->map_lat && $row->map_lng)
                                <h4 class="widget-title">{{ __("Job Location") }}</h4>
                                <div class="widget-content">
                                    @include("Job::frontend.layouts.details.location")
                                </div>
                            @endif

                            @include("Job::frontend.layouts.details.skills")

                        </div>

                        @include("Job::frontend.layouts.details.company")

                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Job Detail Section -->
