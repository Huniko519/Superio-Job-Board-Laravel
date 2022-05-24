<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Company List")}}</h3>
        <p class="form-group-desc">{{__('Config page list company of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="company_page_search_title" value="{{setting_item_with_lang('company_page_search_title',request()->query('lang'),$settings['company_page_search_title'] ?? __("Find Company"))}}" class="form-control">
                    </div>
                </div>
                @if(is_default_lang())
                    <div class="form-group">
                        <label class="" >{{__("Page list company layout")}}</label>
                        <div class="form-controls">
                            <select name="company_list_layout" class="form-control">
                                <option value="company-list-v1" @if(setting_item('company_list_layout') == 'company-list-v1') selected @endif >{{ __("V1") }}</option>
                                <option value="company-list-v2" @if(setting_item('company_list_layout') == 'company-list-v2') selected @endif >{{ __("V2") }}</option>
                                <option value="company-list-v3" @if(setting_item('company_list_layout') == 'company-list-v3') selected @endif >{{ __("V3") }}</option>
                                <option value="company-list-v4" @if(setting_item('company_list_layout') == 'company-list-v4') selected @endif >{{ __("V4") }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Company Single Layout")}}</label>
                        <div class="form-controls">
                            <select name="single_company_layout" class="form-control">
                                <option value="company-single-v1" @if(setting_item('single_company_layout') == 'company-single-v1') selected @endif >{{ __("V1") }}</option>
                                <option value="company-single-v2" @if(setting_item('single_company_layout') == 'company-single-v2') selected @endif >{{ __("V2") }}</option>
                                <option value="company-single-v3" @if(setting_item('single_company_layout') == 'company-single-v3') selected @endif >{{ __("V3") }}</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(is_default_lang())
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Enable Hide Email")}}</label>
                        <div class="form-controls">
                            <label> <input type="checkbox" @if($settings['enable_hide_email_company'] ?? '' == 1) checked @endif name="enable_hide_email_company" value="1"> {{__("Hide company email")}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Sidebar - Search fields")}}</label>
                        <div class="form-controls">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-5">{{__("Title")}}</div>
                                        <div class="col-md-4">{{__('Type')}}</div>
                                        <div class="col-md-2">{{__('Order')}}</div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="g-items">
                                    <?php
                                    $languages = \Modules\Language\Models\Language::getActive();
                                    if(!empty($settings['company_sidebar_search_fields'])){
                                    $company_sidebar_search_fields  = json_decode($settings['company_sidebar_search_fields']);

                                    ?>
                                    @foreach($company_sidebar_search_fields as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                                        @foreach($languages as $language)
                                                            <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : "";
                                                            $title_lang = 'title'.$key_lang;
                                                            ?>
                                                            <div class="g-lang">
                                                                <div class="title-lang">{{$language->name}}</div>
                                                                <input type="text" name="company_sidebar_search_fields[{{$key}}][title{{$key_lang}}]" class="form-control" placeholder="{{__('Title')}}" value="{{$item->$title_lang ?? ''}}">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <input type="text" name="company_sidebar_search_fields[{{$key}}][title]" class="form-control" placeholder="{{__('Title')}}" value="{{$item->title}}">
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="company_sidebar_search_fields[{{$key}}][type]">
                                                        <option value="keyword" @if(!empty($item->type) && $item->type=='keyword') selected @endif>{{__("Keyword")}}</option>
                                                        <option value="location" @if(!empty($item->type) && $item->type=='location') selected @endif>{{__("Location")}}</option>
                                                        <option value="category" @if(!empty($item->type) && $item->type=='category') selected @endif>{{__("Category")}}</option>
                                                        <option value="att" @if(!empty($item->type) && $item->type=='att') selected @endif>{{__("Attribute")}}</option>
                                                        <option value="founded_date" @if(!empty($item->type) && $item->type=='founded_date') selected @endif>{{__("Founded Date")}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" name="company_sidebar_search_fields[{{$key}}][position]" min="0" value="{{$item->position ?? 1}}" class="form-control">
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
                                            <div class="col-md-5">
                                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                                    @foreach($languages as $language)
                                                        <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                        <div class="g-lang">
                                                            <div class="title-lang">{{$language->name}}</div>
                                                            <input type="text" __name__="company_sidebar_search_fields[__number__][title{{$key}}]" class="form-control" placeholder="{{__('Title')}}">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <input type="text" __name__="company_sidebar_search_fields[__number__][title]" class="form-control" placeholder="{{__('Title')}}">
                                                @endif

                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" __name__="company_sidebar_search_fields[__number__][type]">
                                                    <option value="keyword">{{__("Keyword")}}</option>
                                                    <option value="location">{{__("Location")}}</option>
                                                    <option value="category">{{__("Category")}}</option>
                                                    <option value="att">{{__("Attribute")}}</option>
                                                    <option value="founded_date">{{__("Founded Date")}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" __name__="company_sidebar_search_fields[__number__][position]" min="0" value="1" class="form-control">
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

                    @if(is_default_lang())
                        <div class="form-group">
                            <label class="" >{{__("Location Field Style")}}</label>
                            <div class="form-controls">
                                <select name="company_location_search_style" class="form-control">
                                    <option value="normal" @if(setting_item('company_location_search_style') == 'normal') selected @endif >{{ __("Normal") }}</option>
                                    <option value="autocomplete" @if(setting_item('company_location_search_style') == 'autocomplete') selected @endif >{{ __("Autocomplete from locations") }}</option>
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @php
            $company_sidebar_cta = setting_item_with_lang('company_sidebar_cta',request()->query('lang'), $settings['company_sidebar_cta'] ?? false);
            if(!empty($company_sidebar_cta)) $company_sidebar_cta = json_decode($company_sidebar_cta);
        @endphp
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Sidebar - Call to action")}}</label>
                    <div class="form-group-border p-3" style="border: 1px solid #ddd">
                        <div class="form-group">
                            <label>{{ __("Title") }}</label>
                            <div class="form-controls">
                                <input type="text" name="company_sidebar_cta[title]" value="{{ $company_sidebar_cta->title ?? __("Recruiting?") }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Description") }}</label>
                            <div class="form-controls">
                                <textarea name="company_sidebar_cta[desc]" class="form-control">{{ $company_sidebar_cta->desc ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Button") }}</label>
                            <div class="form-controls">
                                <div class="input-group">
                                    <input type="text" name="company_sidebar_cta[button][url]" class="form-control" placeholder="{{ __("Url") }}" value="{{ $company_sidebar_cta->button->url ?? '' }}">
                                    <input type="text" name="company_sidebar_cta[button][name]" class="form-control" placeholder="{{ __("Name") }}" value="{{ $company_sidebar_cta->button->name ?? '' }}">
                                    <div class="input-group-append">
                                        <select name="company_sidebar_cta[button][target]" class="form-control">
                                            <option value="" selected disabled>{{ __("Target") }}</option>
                                            <option value="_self" @if(($company_sidebar_cta->button->target ?? '') == '_self') selected @endif>{{ __("Same window") }}</option>
                                            <option value="_blank" @if(($company_sidebar_cta->button->target ?? '') == '_blank') selected @endif>{{ __("Open new tab") }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Image") }}</label>
                            <div class="form-controls">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('company_sidebar_cta[image]', $company_sidebar_cta->image ?? '') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("SEO Options")}}</label>
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
                                <input type="text" name="company_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('company_page_list_seo_title',request()->query('lang'),$settings['company_page_list_seo_title'] ?? "")}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="company_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('company_page_list_seo_desc',request()->query('lang'),$settings['company_page_list_seo_desc'] ?? "")}}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Featured Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('company_page_list_seo_image', $settings['company_page_list_seo_image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        @php $seo_share = !empty($settings['company_page_list_seo_share']) ? json_decode($settings['company_page_list_seo_share'],true): false;
                        $seo_share = setting_item_with_lang('company_page_list_seo_share',request()->query('lang'),$seo_share)
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="company_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="company_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Facebook Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('company_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="company_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="company_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Twitter Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('company_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
