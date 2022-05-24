<aside class="sidebar">
    @if(!empty($packages=$row->packages))
        <form class="bravo_form_book_gig">
            <input type="hidden" name="gig_id" value="{{ $row->id }}">
            <div class="default-tabs style-two tabs-box">
                <ul class="tab-buttons clearfix">
                    @foreach($packages as $key => $item)
                        @php
                            $price = $row->basic_price;
                            if( $key == 1){
                                $price = $row->standard_price;
                            }
                            if( $key == 2){
                                 $price = $row->premium_price;
                            }
                            $packages[$key]['price'] = $price;
                        @endphp
                        @if(!empty($price))
                            <li class="tab-btn @if($key == 0) active-btn @endif" data-tab="#tab_price_{{$key}}">
                                {{package_key_to_name($item['key'])}}
                                <input class="d-none" type="radio" name="package" @if($key == 0) checked @endif value="{{ $item['key'] }}">
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="tabs-content pb-0">
                    @foreach($packages as $key => $item)
                        @if(!empty($item['price']))
                            <div class="tab fadeIn @if($key == 0) active-tab @endif" id="tab_price_{{$key}}">
                                <div class="d-flex justify-content-between align-items-center mb-3 fs-16">
                                    <div><strong>{{!empty($item['name']) ? $item['name'] : package_key_to_name($item['key'])}}</strong></div>
                                    <div>
                                        <strong class="fs-18">{{format_money($item['price'])}}</strong>
                                    </div>
                                </div>

                                <div class="mb-3">{{$item['desc'] ?? ""}}</div>
                                <div class="include mb-3">
                                    <div class="item fw-500">
                                        <i class="flaticon-clock"></i> {{ __(":number Day Delivery",['number'=>$item['delivery_time'] ?? ""]) }}
                                    </div>
                                    <div class="item fw-500">
                                        <i class="flaticon-reload"></i>
                                        @if($item['revision'] == -1)
                                            {{ __("Unlimited") }}
                                        @else
                                            {{ __(":number Revisions",['number'=>$item['revision'] ?? ""]) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if(!empty($extra_price = $row->extra_price) and !empty($extra_price[0]['price']))
                    <div class="extra mt-4">
                        <strong>
                            {{ __("Extra services") }}
                        </strong>
                        <div class="checkbox-outer margin-top-10">
                            <ul class="checkboxes square">
                                @foreach( $extra_price as $key3=>$item3 )
                                    <li>
                                        <input id="check-{{ $key3 }}" type="checkbox" name="extra_services[{{$key3}}][enable]" value="1">
                                        <label class="d-flex justify-content-between" for="check-{{ $key3 }}">
                                            <div class="name">{{ $item3['name'] }}</div>
                                            <div class="val">{{ format_money($item3['price']) }}</div>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="action text-center mt-4">
                    <div>
                        <button class="btn btn-success w-100 btn-add-cart" type="button">
                            {{ __("Continue") }} <i class="fa fa-spinner fa-spin d-none is_loading" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-default  w-100 compare_packages"  type="button"> {{ __("Compare Packages") }} </button>
                    </div>
                    <div class="msg"></div>
                </div>
            </div>
        </form>
    @endif
</aside>
