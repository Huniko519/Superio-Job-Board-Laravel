<!-- Job Section -->
<section class="job-section-two">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="row wow fadeInUp">
            @foreach($rows as $row)
                <div class="job-block-two col-lg-12">
                    @include("Job::frontend.layouts.loop.job-item-2")
                </div>
            @endforeach
        </div>
        @if(!empty($load_more_url))
            <div class="btn-box">
                <a href="{{ $load_more_url }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">{{ __("Load More Listing") }}</span></a>
            </div>
        @endif
    </div>
</section>
<!-- End Job Section -->
