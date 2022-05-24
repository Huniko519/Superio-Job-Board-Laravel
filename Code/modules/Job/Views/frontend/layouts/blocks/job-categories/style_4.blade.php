<!-- Job Categories -->
<section class="job-categories style-two">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            @if(!empty($sub_title))<div class="text">{{ $sub_title }}</div>@endif
        </div>

        <div class="row wow fadeInUp">
            @if($job_categories)
                @foreach($job_categories as $category)
                    @php $translation = $category->translateOrOrigin(app()->getLocale()); @endphp
                    <!-- Category Block -->
                    <div class="category-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <a href="{{ route('job.search', ['category' => $category->id]) }}">
                                <div class="content @if(empty($category->icon)) no-icon @endif">
                                    @if($category->icon)
                                        <span class="icon {{ $category->icon }}"></span>
                                    @endif
                                    <h4>{{ $translation->name }}</h4>
                                    @if($category->openJobs->count())
                                        <p>({{ $category->openJobs->count() }} {{ $category->openJobs->count() > 1 ? __("open positions") : __("open position") }})</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Job Categories -->
