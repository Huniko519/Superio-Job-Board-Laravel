<div class="bravo-companies job-detail-section">
    <div class="job-detail-outer">
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
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
                    <aside class="sidebar">
                    <div class="btn-box">
                        <a href="#" class="theme-btn btn-style-one btn-send-message">Send Message</a>
                        <button class="bookmark-btn @if($row->wishlist) active @endif service-wishlist" data-id="{{$row->id}}" data-type="{{$row->type}}"><i class="flaticon-bookmark"></i></button>
                    </div>
                    @include('Company::frontend.layouts.details.companies-sidebar-v3')
                    @include('Job::frontend.layouts.details.contact',['origin_id'=>$row->id,'job_id'=>false])
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
