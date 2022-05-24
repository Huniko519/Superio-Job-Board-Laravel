<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Page Search")}}</h3>
        <p class="form-group-desc">{{__('Config page search of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("General Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group ">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="gig_page_search_title" value="{{setting_item_with_lang('gig_page_search_title',request()->query('lang'))}}" class="form-control">
                    </div>
                </div>
                @if(is_default_lang())
                <div class="form-group">
                    <label class="" >{{__("Limit item per Page")}}</label>
                    <div class="form-controls">
                        <input type="number" min="1" name="gig_page_limit_item" placeholder="{{ __("Default: 24") }}" value="{{setting_item('gig_page_limit_item', 24)}}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="" >{{__("Maximum posting gigs")}}</label>
                    <div class="form-controls">
                        <input type="number" name="gig_max_posts" value="{{setting_item('gig_max_posts', '')}}" class="form-control">
                        <small><i>{{ __("0 or blank: unlimited") }}</i></small>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="panel">
            <div class="panel-title"><strong>{{__("SEO Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#seo_1">{{__("General Options")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#seo_2">{{__("Share Facebook")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#seo_3">{{__("Share Twitter")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div class="tab-pane active" id="seo_1">
                            <div class="form-group" >
                                <label class="control-label">{{__("Seo Title")}}</label>
                                <input type="text" name="gig_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('gig_page_list_seo_title',request()->query('lang'))}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="gig_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('gig_page_list_seo_desc',request()->query('lang'))}}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Featured Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('gig_page_list_seo_image', $settings['gig_page_list_seo_image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        @php
                            $seo_share = json_decode(setting_item_with_lang('gig_page_list_seo_desc',request()->query('lang'),'[]'),true);
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="gig_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="gig_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Facebook Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('gig_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="gig_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="gig_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Twitter Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('gig_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(is_default_lang())
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Review Options")}}</h3>
            <p class="form-group-desc">{{__('Config review for gig')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Enable review system for Gig?")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="gig_enable_review" value="1" @if(!empty($settings['gig_enable_review'])) checked @endif /> {{__("Yes, please enable it")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("Turn on the mode for reviewing gig")}}</small>
                        </div>
                    </div>
                    <div class="form-group" data-condition="gig_enable_review:is(1)">
                        <label class="" >{{__("Review number per page")}}</label>
                        <div class="form-controls">
                            <input type="number" class="form-control" name="gig_review_number_per_page" value="{{ $settings['gig_review_number_per_page'] ?? 5 }}" />
                            <small class="form-text text-muted">{{__("Break comments into pages")}}</small>
                        </div>
                    </div>
                    <div class="form-group" data-condition="gig_enable_review:is(1)">
                        <label class="" >{{__("Review criteria")}}</label>
                        <div class="form-controls">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-5">{{__("Title")}}</div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="g-items">
                                    <?php
                                    if(!empty($settings['gig_review_stats'])){
                                    $social_share = json_decode($settings['gig_review_stats']);
                                    ?>
                                    @foreach($social_share as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" name="gig_review_stats[{{$key}}][title]" class="form-control" value="{{$item->title}}" placeholder="{{__('Eg: Service')}}">
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <?php } ?>
                                </div>
                                <div class="text-right">
                                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                                </div>
                                <div class="g-more hide">
                                    <div class="item" data-number="__number__">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <input type="text" __name__="gig_review_stats[__number__][title]" class="form-control" value="" placeholder="{{__('Eg: Service')}}">
                                            </div>
                                            <div class="col-md-1">
                                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(is_default_lang())
    @if(is_default_lang())
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <h3 class="form-group-title">{{__("Booking Options")}}</h3>
                <p class="form-group-desc">{{__('Config Booking for event')}}</p>
            </div>
            <div class="col-sm-8">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-group-item">
                            <label class="control-label">{{__('Booking Buyer Fees')}}</label>
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-5">{{__("Name")}}</div>
                                    <div class="col-md-3">{{__('Price')}}</div>
                                    <div class="col-md-3">{{__('Type')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items">
                                <?php  $languages = \Modules\Language\Models\Language::getActive();  ?>
                                @if(!empty($settings['gig_booking_buyer_fees']))
                                    <?php $gig_booking_buyer_fees = json_decode($settings['gig_booking_buyer_fees'],true); ?>
                                    @foreach($gig_booking_buyer_fees as $key=>$buyer_fee)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                                        @foreach($languages as $language)
                                                            <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                            <div class="g-lang">
                                                                <div class="title-lang">{{$language->name}}</div>
                                                                <input type="text" name="gig_booking_buyer_fees[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$buyer_fee['name'.$key_lang] ?? ''}}" placeholder="{{__('Fee name')}}">
                                                                <input type="text" name="gig_booking_buyer_fees[{{$key}}][desc{{$key_lang}}]" class="form-control" value="{{$buyer_fee['desc'.$key_lang] ?? ''}}" placeholder="{{__('Fee desc')}}">
                                                            </div>

                                                        @endforeach
                                                    @else
                                                        <input type="text" name="gig_booking_buyer_fees[{{$key}}][name]" class="form-control" value="{{$buyer_fee['name'] ?? ''}}" placeholder="{{__('Fee name')}}">
                                                        <input type="text" name="gig_booking_buyer_fees[{{$key}}][desc]" class="form-control" value="{{$buyer_fee['desc'] ?? ''}}" placeholder="{{__('Fee desc')}}">
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" min="0" step="0.1"  name="gig_booking_buyer_fees[{{$key}}][price]" class="form-control" value="{{$buyer_fee['price']}}">
                                                    <select name="gig_booking_buyer_fees[{{$key}}][unit]" class="form-control">
                                                        <option @if( ($buyer_fee['unit'] ?? "") ==  'fixed') selected @endif value="fixed">{{ __("Fixed") }}</option>
                                                        <option @if( ($buyer_fee['unit'] ?? "") ==  'percent') selected @endif value="percent">{{ __("Percent") }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-8">
                                            @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                                @foreach($languages as $language)
                                                    <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                    <div class="g-lang">
                                                        <div class="title-lang">{{$language->name}}</div>
                                                        <input type="text" __name__="gig_booking_buyer_fees[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Fee name')}}">
                                                        <input type="text" __name__="gig_booking_buyer_fees[__number__][desc{{$key}}]" class="form-control" value="" placeholder="{{__('Fee desc')}}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <input type="text" __name__="gig_booking_buyer_fees[__number__][name]" class="form-control" value="" placeholder="{{__('Fee name')}}">
                                                <input type="text" __name__="gig_booking_buyer_fees[__number__][desc]" class="form-control" value="" placeholder="{{__('Fee desc')}}">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" min="0" step="0.1"  __name__="gig_booking_buyer_fees[__number__][price]" class="form-control" value="">
                                            <select __name__="gig_booking_buyer_fees[__number__][unit]" class="form-control">
                                                <option value="fixed">{{ __("Fixed") }}</option>
                                                <option value="percent">{{ __("Percent") }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Commission')}}</h3>
        <p class="form-group-desc">{{__('Change your commission config')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group" >
                        <label>{{__('Commission Type')}}</label>
                        <div class="form-controls">
                            <select name="vendor_commission_type" class="form-control">
                                <option value="percent" {{($settings['vendor_commission_type'] ?? '') == 'percent' ? 'selected' : ''  }}>{{__('Percent')}}</option>
                                <option value="amount" {{($settings['vendor_commission_type'] ?? '') == 'amount' ? 'selected' : ''  }}>{{__('Amount')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label>{{__('Commission Value')}}</label>
                        <div class="form-controls">
                            <input type="text" class="form-control" name="vendor_commission_amount" value="{{!empty($settings['vendor_commission_amount'])?$settings['vendor_commission_amount']:"0" }}">
                        </div>
                        <p>
                            <i>{{__('Example value : 10 or 10.5')}}</i><br>
                            <i>{{__('Example: 10% commission. Seller get 90%, Admin get 10%')}}</i>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<hr>
@if(is_default_lang())
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Gig Order')}}</h3>
        <p class="form-group-desc">{{__('Change gig order config')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group" >
                    <label>{{__('Number of days to auto complete delivered orders')}}</label>
                    <div class="form-controls">
                        <input type="number" step="1" class="form-control" name="gig_days_complete_order" value="{{!empty($settings['gig_days_complete_order'])?$settings['gig_days_complete_order']:3 }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
@endif
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Disable Gig module?")}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Disable Gig module")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-controls">
                    <label><input type="checkbox" name="gig_disable" value="1" @if(setting_item('gig_disable')) checked @endif > {{__('Yes, please disable it')}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

