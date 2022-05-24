<section class="job-section-four">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="row">
            @foreach($rows as $row)
                <div class="job-block-four col-lg-4 col-md-6 col-sm-12">
                    @include("Job::frontend.layouts.loop.job-item-5")
                </div>
            @endforeach
        </div>

        <div class="btn-box">
            <a href="{{ $load_more_url }}" class="theme-btn btn-style-seven">{{ __("Load More Listing") }}</a>
        </div>
    </div>
</section>
