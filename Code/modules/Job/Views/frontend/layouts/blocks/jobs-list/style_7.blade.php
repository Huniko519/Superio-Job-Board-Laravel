<section class="job-section pt-0 style-7">
    <div class="auto-container">
        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{{ $sub_title }}</div>
            </div>
            @if(!empty($categories))
            <div class="select-box-outer">
                <span class="icon fa fa-angle-down"></span>
                <select name="category_id">
                    <option value="">{{ __("All Categories") }}</option>
                    @foreach($categories as $k => $cat)
                        @php $translation = $cat->translateOrOrigin(app()->getLocale()); @endphp
                        <option value="{{ $cat->id }}">{{ $translation->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>

        <div class="row wow fadeInUp">
            @foreach($rows as $row)
                <div class="job-block col-lg-6 col-md-12 col-sm-12 @if($row->category) category_{{ $row->category->id }} @endif">
                    @include("Job::frontend.layouts.loop.job-item-7")
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
