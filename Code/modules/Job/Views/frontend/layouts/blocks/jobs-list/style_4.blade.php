<section class="job-section alternate">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        @if(!empty($categories))
            <div class="default-tabs tabs-box">
                <ul class="tab-buttons">
                    <li class="tab-btn active-btn" data-tab="#tab0">All</li>
                    @foreach($categories as $k => $cat)
                        @php $translation = $cat->translateOrOrigin(app()->getLocale()); @endphp
                        <li class="tab-btn" data-tab="#tab{{ $k + 1 }}">{{ $translation->name }}</li>
                    @endforeach
                </ul>
                <div class="tabs-content wow fadeInUp">
                    <div class="tab active-tab" id="tab0">
                        <div class="row">
                            @foreach($rows as $row)
                                <div class="job-block-three col-lg-6 col-md-12 col-sm-12">
                                    @include("Job::frontend.layouts.loop.job-item-3")
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @foreach($categories as $k => $cat)
                        <div class="tab" id="tab{{$k + 1}}">
                            <div class="row">
                                @foreach($tabs as $row)
                                    @if($cat->id == $row->category_id)
                                        <div class="job-block-three col-lg-6 col-md-12 col-sm-12">
                                            @include("Job::frontend.layouts.loop.job-item-3")
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
