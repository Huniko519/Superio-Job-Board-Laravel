<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Candidates List")}}</h3>
        <p class="form-group-desc">{{__('Config page list candidates of your website')}}</p>
    </div>
    <div class="col-sm-8">
        @if(is_default_lang())
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Candidate Single Layout")}}</label>
                        <div class="form-controls">
                            <select class="form-control" name="candidate_single_layout">
                                @for($i = 1; $i <= 2; $i++)
                                    <option value="v{{$i}}" @if(setting_item('candidate_single_layout','v1') == "v$i") selected @endif>{{ __('Version :ver',['ver' => $i]) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Candidate List Layout")}}</label>
                        <div class="form-controls">
                            <select class="form-control" name="candidate_list_layout">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="v{{$i}}" @if(setting_item('candidate_list_layout','v1') == "v$i") selected @endif>{{ __('Version :ver',['ver' => $i]) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="candidate_page_search_title" value="{{setting_item_with_lang('candidate_page_search_title',request()->query('lang'),$settings['candidate_page_search_title'] ?? __("Find Candidates"))}}" class="form-control">
                    </div>
                </div>
                @if(is_default_lang())
                    <div class="form-group">
                        <label class="" >{{__("Login required to download CV?")}}</label>
                        <div class="form-controls">
                            <input type="checkbox" name="candidate_download_cv_required_login" @if(!empty(setting_item('candidate_download_cv_required_login'))) checked @endif value="1" class="form-control"> {{ __("On") }}
                        </div>
                    </div>
                @endif
                @if(is_default_lang())
                    <div class="form-group">
                        <label class="" >{{__("Maximum value")}}</label>
                        <div class="form-controls">
                            <input type="number" name="candidate_maximum_job_apply" value="{{setting_item('candidate_maximum_job_apply', '') ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Limit to apply by")}}</label>
                        @php $candidate_limit_apply_by = setting_item('candidate_limit_apply_by', ''); @endphp
                        <div class="form-controls">
                            <select class="form-control" name="candidate_limit_apply_by">
                                <option value="none">{{ __("None") }}</option>
                                <option value="day" @if($candidate_limit_apply_by == 'day') selected @endif>{{ __("Limit by day") }}</option>
                                <option value="month" @if($candidate_limit_apply_by == 'month') selected @endif>{{ __("Limit by month") }}</option>
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
                                    if(!empty($settings['candidate_sidebar_search_fields'])){
                                    $candidate_sidebar_search_fields  = json_decode($settings['candidate_sidebar_search_fields']);
                                    ?>
                                    @foreach($candidate_sidebar_search_fields as $key=>$item)
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
                                                                <input type="text" name="candidate_sidebar_search_fields[{{$key}}][title{{$key_lang}}]" class="form-control" placeholder="{{__('Title')}}" value="{{$item->$title_lang ?? ''}}">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <input type="text" name="candidate_sidebar_search_fields[{{$key}}][title]" class="form-control" placeholder="{{__('Title')}}" value="{{$item->title ?? ''}}">
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="candidate_sidebar_search_fields[{{$key}}][type]">
                                                        <option value="keyword" @if(!empty($item->type) && $item->type=='keyword') selected @endif>{{__("Keyword")}}</option>
                                                        <option value="location" @if(!empty($item->type) && $item->type=='location') selected @endif>{{__("Location")}}</option>
                                                        <option value="category" @if(!empty($item->type) && $item->type=='category') selected @endif>{{__("Category")}}</option>
                                                        <option value="skill" @if(!empty($item->type) && $item->type=='skill') selected @endif>{{__("Skill")}}</option>
                                                        <option value="education" @if(!empty($item->type) && $item->type=='education') selected @endif>{{__("Education Level")}}</option>
                                                        <option value="date_posted" @if(!empty($item->type) && $item->type=='date_posted') selected @endif>{{__("Date Posted")}}</option>
                                                        <option value="experience" @if(!empty($item->type) && $item->type=='experience') selected @endif>{{__("Experience Level")}}</option>
                                                        <option value="salary" @if(!empty($item->type) && $item->type=='salary') selected @endif>{{__("Salary")}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" name="candidate_sidebar_search_fields[{{$key}}][position]" min="0" value="{{$item->position ?? 1}}" class="form-control">
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
                                                            <input type="text" __name__="candidate_sidebar_search_fields[__number__][title{{$key}}]" class="form-control" placeholder="{{__('Title')}}">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <input type="text" __name__="candidate_sidebar_search_fields[__number__][title]" class="form-control" placeholder="{{__('Title')}}">
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" __name__="candidate_sidebar_search_fields[__number__][type]">
                                                    <option value="keyword">{{__("Keyword")}}</option>
                                                    <option value="location">{{__("Location")}}</option>
                                                    <option value="category">{{__("Category")}}</option>
                                                    <option value="education">{{__("Education Level")}}</option>
                                                    <option value="date_posted">{{__("Date Posted")}}</option>
                                                    <option value="experience">{{__("Experience Level")}}</option>
                                                    <option value="salary">{{__("Salary")}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" __name__="candidate_sidebar_search_fields[__number__][position]" min="0" value="1" class="form-control">
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
                                <select name="candidate_location_search_style" class="form-control">
                                    <option value="normal" @if(setting_item('candidate_location_search_style') == 'normal') selected @endif >{{ __("Normal") }}</option>
                                    <option value="autocomplete" @if(setting_item('candidate_location_search_style') == 'autocomplete') selected @endif >{{ __("Autocomplete from locations") }}</option>
                                </select>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endif
        @php
            $candidate_sidebar_cta = setting_item_with_lang('candidate_sidebar_cta',request()->query('lang'), $settings['candidate_sidebar_cta'] ?? false);
            if(!empty($candidate_sidebar_cta)) $candidate_sidebar_cta = json_decode($candidate_sidebar_cta);
        @endphp
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Sidebar - Call to action")}}</label>
                    <div class="form-group-border p-3" style="border: 1px solid #ddd">
                        <div class="form-group">
                            <label>{{ __("Title") }}</label>
                            <div class="form-controls">
                                <input type="text" name="candidate_sidebar_cta[title]" value="{{ $candidate_sidebar_cta->title ?? __("Recruiting?") }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Description") }}</label>
                            <div class="form-controls">
                                <textarea name="candidate_sidebar_cta[desc]" class="form-control">{{ $candidate_sidebar_cta->desc ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Button") }}</label>
                            <div class="form-controls">
                                <div class="input-group">
                                    <input type="text" name="candidate_sidebar_cta[button][url]" class="form-control" placeholder="{{ __("Url") }}" value="{{ $candidate_sidebar_cta->button->url ?? '' }}">
                                    <input type="text" name="candidate_sidebar_cta[button][name]" class="form-control" placeholder="{{ __("Name") }}" value="{{ $candidate_sidebar_cta->button->name ?? '' }}">
                                    <div class="input-group-append">
                                        <select name="candidate_sidebar_cta[button][target]" class="form-control">
                                            <option value="" selected disabled>{{ __("Target") }}</option>
                                            <option value="self" @if(($candidate_sidebar_cta->button->target ?? '') == 'self') selected @endif>{{ __("Same window") }}</option>
                                            <option value="blank" @if(($candidate_sidebar_cta->button->target ?? '') == 'blank') selected @endif>{{ __("Open new tab") }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __("Image") }}</label>
                            <div class="form-controls">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('candidate_sidebar_cta[image]', $candidate_sidebar_cta->image ?? '') !!}
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
                                <input type="text" name="candidate_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('candidate_page_list_seo_title',request()->query('lang'),$settings['candidate_page_list_seo_title'] ?? "")}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="candidate_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('candidate_page_list_seo_desc',request()->query('lang'),$settings['candidate_page_list_seo_desc'] ?? "")}}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Featured Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('candidate_page_list_seo_image', $settings['candidate_page_list_seo_image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        @php $seo_share = !empty($settings['candidate_page_list_seo_share']) ? json_decode($settings['candidate_page_list_seo_share'],true): false;
                        $seo_share = setting_item_with_lang('candidate_page_list_seo_share',request()->query('lang'),$seo_share)
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="candidate_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="candidate_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Facebook Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('candidate_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="candidate_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="candidate_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Twitter Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('candidate_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
