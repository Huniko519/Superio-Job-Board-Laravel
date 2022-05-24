<div class="bravo-companies job-detail-section">
    <div class="upper-box">
        <div class="auto-container">
            <!-- Job Block -->
            <div class="job-block-seven style-three">
                <div class="inner-box">
                    <div class="content">
                        <span class="company-logo">
                            @if($image_tag = get_image_tag($row->avatar_id,'full',['alt'=>$translation->title]))
                                {!! $image_tag !!}
                            @endif
                        </span>
                        <h4>{{ $translation->name }}</h4>
                        @if($row->job_count > 0)
                            <ul class="job-other-info">
                                <li class="time">{{ __("Open Jobs – :count",["count"=>number_format($row->job_count)]) }}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="job-detail-outer">
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-8 col-md-12 col-sm-12 order-2">
                    <div class="job-detail">
                        <h4>{{__("About Company")}}</h4>
                        {!! $translation->about !!}
                    </div>
                    <!-- Related Jobs -->
                    <div class="related-jobs">
                        @if($row->job_count > 0)
                            <div class="title-box">
                                <h3>{{ __(":count jobs at :title",["count"=>$row->job_count, "title"=> $translation->name]) }}</h3>
                            </div>
                        @endif
                        @if($jobs->count() > 0)
                            @foreach($jobs as $job)
                                <div class="job-block">
                                    @include('Job::frontend.layouts.loop.job-item-1', ['row' => $job])
                                </div>
                            @endforeach
                        @endif
                        <div class="ls-pagination">
                            {{$jobs->appends(request()->query())->links()}}
                            @if($jobs->total() > 0)
                                <span class="count-string">{{ __("Showing :from - :to of :total",["from"=>$jobs->firstItem(),"to"=>$jobs->lastItem(),"total"=>$jobs->total()]) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    @include('Company::frontend.layouts.details.companies-sidebar')
                    @include('Job::frontend.layouts.details.contact',['origin_id'=>$row->id,'job_id'=>false])
                </div>
            </div>
        </div>
    </div>
</div>
