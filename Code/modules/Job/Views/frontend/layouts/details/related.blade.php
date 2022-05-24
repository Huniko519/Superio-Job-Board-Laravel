@if(!empty($job_related) && count($job_related) > 0)
    <!-- Related Jobs -->
    <div class="related-jobs">
        <div class="title-box">
            <h3>{{ __("Related Jobs") }}</h3>
        </div>
        @if(!empty($item_style) && $item_style == 'job-item-4')
            <div class="row">
                @foreach($job_related as $row)
                    <div class="job-block-four col-lg-6 col-md-6 col-sm-12">
                        @include("Job::frontend.layouts.loop." . $item_style)
                    </div>
                @endforeach
            </div>
        @else
            @foreach($job_related as $row)
                <div class="job-block">
                    @include("Job::frontend.layouts.loop.job-item-1")
                </div>
            @endforeach
        @endif
    </div>
@endif
