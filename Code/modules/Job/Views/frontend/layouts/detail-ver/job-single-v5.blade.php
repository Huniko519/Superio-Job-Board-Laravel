<!-- Job Detail Section -->
<section class="job-detail-section style-three">
    <!-- Upper Box -->
    <div class="upper-box">
        <div class="auto-container">
            <!-- Job Block -->
            <div class="job-block-seven style-three">
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
                <div class="content-column col-lg-8 offset-2 col-md-12 col-sm-12">
                    @include("Job::frontend.layouts.details.overview-2")

                    <div class="job-detail">
                        {!! @clean($translation->content) !!}
                    </div>

                    @include("Job::frontend.layouts.details.gallery")

                    @include("Job::frontend.layouts.details.video")

                    <!-- Other Options -->
                    @include("Job::frontend.layouts.details.social-share")

                    @if($row->map_lat && $row->map_lng)
                        @include("Job::frontend.layouts.details.location")
                    @endif

                    <!-- Related Jobs -->
                    @include("Job::frontend.layouts.details.related")

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Job Detail Section -->
