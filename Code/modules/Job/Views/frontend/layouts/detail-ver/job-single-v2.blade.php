<!-- Job Detail Section -->
<section class="job-detail-section">
    <div class="job-detail-outer">
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
                    <div class="job-block-outer">
                        <!-- Job Block -->
                        <div class="job-block-seven">
                            <div class="inner-box">
                                @include("Job::frontend.layouts.details.upper-box")
                            </div>
                        </div>
                    </div>
                    <div class="job-detail">
                        {!! @clean($translation->content) !!}
                    </div>

                    @include("Job::frontend.layouts.details.gallery")

                    @include("Job::frontend.layouts.details.video")

                    @include("Job::frontend.layouts.details.social-share")

                    @if($row->map_lat && $row->map_lng)
                        @include("Job::frontend.layouts.details.location")
                    @endif

                    @include("Job::frontend.layouts.details.related", ['item_style' => 'job-item-4'])
                </div>

                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">

                        @include("Job::frontend.layouts.details.apply-button")

                        <div class="sidebar-widget">

                            @include("Job::frontend.layouts.details.overview")

                            @include("Job::frontend.layouts.details.skills")
                        </div>

                        @include("Job::frontend.layouts.details.company-2")

                        @if(!empty($row->company->id))
                            @include("Job::frontend.layouts.details.contact", ['origin_id' => $row->company->id, 'job_id' => $row->id])
                        @endif

                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Job Detail Section -->
