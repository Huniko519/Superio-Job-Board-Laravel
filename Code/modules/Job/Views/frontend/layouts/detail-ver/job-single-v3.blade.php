<!-- Job Detail Section -->
<section class="job-detail-section">
    <div class="job-detail-outer">
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
                    <div class="job-block-outer">
                        <!-- Job Block -->
                        <div class="job-block-seven style-two">
                            <div class="inner-box">
                                @include("Job::frontend.layouts.details.upper-box", ['hide_avatar' => true])
                            </div>
                        </div>
                    </div>

                    @include("Job::frontend.layouts.details.overview-2")

                    <div class="job-detail">

                        {!! @clean($translation->content) !!}

                    </div>

                    @include("Job::frontend.layouts.details.gallery")

                    @include("Job::frontend.layouts.details.video")

                    @include("Job::frontend.layouts.details.social-share")

                    @include("Job::frontend.layouts.details.related", ['item_style' => 'job-item-4'])
                </div>

                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">

                        @include("Job::frontend.layouts.details.apply-button")

                        @include("Job::frontend.layouts.details.company")

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
