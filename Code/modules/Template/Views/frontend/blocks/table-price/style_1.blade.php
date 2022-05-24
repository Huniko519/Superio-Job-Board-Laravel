<!-- Pricing Sectioin -->
<section class="pricing-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>
        <!--Pricing Tabs-->
        <div class="pricing-tabs tabs-box wow fadeInUp">
            <!--Tab Btns-->
            <div class="tab-buttons">
                @if(!empty($sale_off_text))
                    <h4>{{ $sale_off_text }}</h4>
                @endif
                @if(!empty($monthly_list) && !empty($annual_list))
                    <ul class="tab-btns">
                        <li data-tab="#monthly" class="tab-btn active-btn">{{ $monthly_title ?? __("Monthly") }}</li>
                        <li data-tab="#annual" class="tab-btn">{{ $annual_title ?? __("AnnualSave") }}</li>
                    </ul>
                @endif
            </div>

            <!--Tabs Container-->
            <div class="tabs-content">

                @if(!empty($monthly_list) && count($monthly_list) > 0)
                    <!--Tab / Active Tab-->
                    <div class="tab active-tab" id="monthly">
                        <div class="content">
                            <div class="row">
                                @foreach($monthly_list as $key => $val)
                                <!-- Pricing Table -->
                                <div class="pricing-table @if(!empty($val['is_recommended'])) tagged @endif col-lg-4 col-md-6 col-sm-12">
                                    <div class="inner-box">
                                        @if(!empty($val['is_recommended']))
                                            <span class="tag">{{ __("Recommended") }}</span>
                                        @endif
                                        <div class="title">{{ $val['title'] }}</div>
                                        <div class="price">{{ $val['price'] }} @if(!empty($val['unit']))<span class="duration">/ {{$val['unit']}}</span>@endif</div>
                                        <div class="table-content">
                                            {!! @clean($val['featured']) !!}
                                        </div>
                                        @if(!empty($val['button_url']))
                                            <div class="table-footer">
                                                <a href="{{ $val['button_url'] }}" @if(!empty($button_target)) target="_blank" @endif class="theme-btn btn-style-three">{{ $val['button_name'] ?? __("View Profile") }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($annual_list) && count($annual_list) > 0)
                    <!--Tab / Active Tab-->
                    <div class="tab @if(empty($monthly_list) || count($monthly_list) == 0) active-tab @endif" id="annual">
                        <div class="content">
                            <div class="row">
                            @foreach($annual_list as $key => $val)
                                <!-- Pricing Table -->
                                    <div class="pricing-table @if(!empty($val['is_recommended'])) tagged @endif col-lg-4 col-md-6 col-sm-12">
                                        <div class="inner-box">
                                            @if(!empty($val['is_recommended']))
                                                <span class="tag">{{ __("Recommended") }}</span>
                                            @endif
                                            <div class="title">{{ $val['title'] }}</div>
                                            <div class="price">{{ $val['price'] }} @if(!empty($val['unit']))<span class="duration">/ {{$val['unit']}}</span>@endif</div>
                                            <div class="table-content">
                                                {!! @clean($val['featured']) !!}
                                            </div>
                                            @if(!empty($val['button_url']))
                                                <div class="table-footer">
                                                    <a href="{{ $val['button_url'] }}" @if(!empty($button_target)) target="_blank" @endif class="theme-btn btn-style-three">{{ $val['button_name'] ?? __("View Profile") }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End Pricing Section -->
