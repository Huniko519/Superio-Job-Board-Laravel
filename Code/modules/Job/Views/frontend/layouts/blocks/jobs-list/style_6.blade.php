<section class="job-section-five">
    <div class="auto-container">

        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{{ $sub_title }}</div>
            </div>
            <a href="{{ $load_more_url }}" class="link">{{ __('Browse All') }} <span class="icon fa fa-angle-right"></span></a>
        </div>

        <div class="outer-box wow fadeInUp">
            @foreach($rows as $row)
                <div class="job-block-five">
                    @include("Job::frontend.layouts.loop.job-item-6")
                </div>
            @endforeach
        </div>
    </div>
</section>
