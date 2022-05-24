<div class="ls-widget">
    <div class="widget-title">
        <h4>{{__("Active Orders")}}</h4>
        <div class="chosen-outer">
            <!--Tabs Box-->
            <select name="status" class="chosen-select">
                <option>{{__("Active Orders")}}</option>
                <option>{{__("Completed")}}</option>
                <option>{{__('Cancelled')}}</option>
            </select>
        </div>
    </div>
    <div class="widget-content">
        <div class="row">
{{--            @foreach($orders as $order)--}}
            <div class="job-block col-lg-6 col-md-12 col-sm-12">
                <div class="inner-box">
                    <div class="content">
                        <span class="company-logo"><img src="images/resource/company-logo/1-1.png" alt=""></span>
                        <h4><a href="#">Software Engineer (Android), Libraries</a></h4>
                        <ul class="job-info">
                            <li><span class="icon flaticon-briefcase"></span> Segment</li>
                            <li><span class="icon flaticon-map-locator"></span> London, UK</li>
                            <li><span class="icon flaticon-clock-3"></span> 11 hours ago</li>
                            <li><span class="icon flaticon-money"></span> $35k - $45k</li>
                        </ul>
                        <ul class="job-other-info">
                            <li class="time">Full Time</li>
                            <li class="privacy">Private</li>
                            <li class="required">Urgent</li>
                        </ul>
                        <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                    </div>
                </div>
            </div>
{{--            @endforeach--}}
        </div>
    </div>
</div>
