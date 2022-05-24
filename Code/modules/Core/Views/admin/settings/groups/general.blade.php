<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Site Information")}}</h3>
        <p class="form-group-desc">{{__('Information of your website for customer and google')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="">{{__("Site title")}}</label>
                    <div class="form-controls">
                        <input type="text" class="form-control" name="site_title" value="{{setting_item_with_lang('site_title',request()->query('lang'))}}">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{__("Site Desc")}}</label>
                    <div class="form-controls">
                        <textarea name="site_desc" class="form-control" cols="30" rows="7">{{setting_item_with_lang('site_desc',request()->query('lang'))}}</textarea>
                    </div>
                </div>

                @if(is_default_lang())
                <div class="form-group">
                    <label class="" >{{__("Favicon")}}</label>
                    <div class="form-controls form-group-image">
                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('site_favicon',$settings['site_favicon'] ?? "") !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>{{__("Date format")}}</label>
                    <div class="form-controls">
                        <input type="text" class="form-control" name="date_format" value="{{$settings['date_format'] ?? 'm/d/Y' }}">
                    </div>
                </div>
                @endif
                @if(is_default_lang())
                <div class="form-group">
                    <label>{{__("Timezone")}}</label>
                    @php
                        $path = resource_path('module/core/timezone.json');
                        $timezones = json_decode(\Illuminate\Support\Facades\File::get($path));
                    @endphp
                    <div class="form-controls">
                        <select name="site_timezone" class="form-control">
                            <option value="UTC">{{__("-- Default --")}}</option>
                            @if(!empty($timezones))
                                @foreach($timezones as $item=>$value)
                                    <option @if($item == ($settings['site_timezone'] ?? '') ) selected @endif value="{{$item}}">{{$value}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                 <div class="form-group">
                    <label>{{__("Change the first day of week for the calendars")}}</label>
                    <div class="form-controls">
                        <select name="site_first_day_of_the_weekin_calendar" class="form-control">
                            <option @if("1" == ($settings['site_first_day_of_the_weekin_calendar'] ?? '') ) selected @endif value="1">{{__("Monday")}}</option>
                            <option @if("0" == ($settings['site_first_day_of_the_weekin_calendar'] ?? '') ) selected @endif value="0">{{__("Sunday")}}</option>
                        </select>
                    </div>
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
            <h3 class="form-group-title">{{__('General')}}</h3>
            <p class="form-group-desc">{{__('Change your general options')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Page for Terms and Conditions")}}</label>
                        <div class="form-controls">
                            <?php
                            $template = !empty($settings['terms_and_conditions_id']) ? \Modules\Page\Models\Page::find($settings['terms_and_conditions_id']) : false;

                            \App\Helpers\AdminForm::select2('terms_and_conditions_id', [
                                'configs' => [
                                    'ajax' => [
                                        'url'      => url('/admin/module/page/getForSelect2'),
                                        'dataType' => 'json'
                                    ]
                                ]
                            ],
                                !empty($template->id) ? [$template->id, $template->title] : false
                            )
                            ?>
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
        <h3 class="form-group-title">{{__('Language')}}</h3>
        <p class="form-group-desc">{{__('Change language of your websites')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <label>{{__("Select default language")}}</label>
                        <div class="form-controls">
                            <select name="site_locale" class="form-control">
                                <option value="">{{__("-- Default --")}}</option>
                                @php
                                    $langs = \Modules\Language\Models\Language::getActive();
                                @endphp

                                @foreach($langs as $lang)
                                    <option @if($lang->locale == ($settings['site_locale'] ?? '') ) selected @endif value="{{$lang->locale}}">{{$lang->name}} - ({{$lang->locale}})</option>
                                @endforeach
                            </select>
                            <p><i><a href="{{url('admin/module/language')}}">{{__("Manage languages here")}}</a></i></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("Enable Multi Languages")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" @if(setting_item('site_enable_multi_lang') ?? '' == 1) checked @endif name="site_enable_multi_lang" value="1">{{__('Enable')}}</label>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label>{{__("Enable RTL")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" @if(setting_item_with_lang('enable_rtl',request()->query('lang')) ?? '' == 1) checked @endif name="enable_rtl" value="1">{{__('Enable')}}</label>
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
            <h3 class="form-group-title">{{__('Contact Information')}}</h3>
            <p class="form-group-desc">{{__('How your customer can contact to you')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Phone Contact")}}</label>
                        <div class="form-controls">
                            <input type="text" class="form-control" name="phone_contact" value="{{$settings['phone_contact'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__('Homepage')}}</h3>
            <p class="form-group-desc">{{__('Change your homepage content')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Page for Homepage")}}</label>
                        <div class="form-controls">
                            <?php
                            $template = !empty($settings['home_page_id']) ? \Modules\Page\Models\Page::find($settings['home_page_id']) : false;

                            \App\Helpers\AdminForm::select2('home_page_id', [
                                'configs' => [
                                    'ajax' => [
                                        'url'      => url('/admin/module/page/getForSelect2'),
                                        'dataType' => 'json'
                                    ]
                                ]
                            ],
                                !empty($template->id) ? [$template->id, $template->title] : false
                            )
                            ?>
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
        <h3 class="form-group-title">{{__('Header & Footer Settings')}}</h3>
        <p class="form-group-desc">{{__('Change your options')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <label>{{__("Logo")}}</label>
                        <div class="form-controls form-group-image">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('logo_id',$settings['logo_id'] ?? '') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("White Logo")}}</label>
                        <div class="form-controls form-group-image">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('logo_white_id',$settings['logo_white_id'] ?? '') !!}
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label>{{__("Footer Style")}}</label>
                    <div class="form-controls">
                        @php $footer_style = setting_item_with_lang('footer_style', request()->query('lang')) @endphp
                        <select name="footer_style" class="form-control" >
                            <option value="style_1" @if($footer_style == 'style_1') selected @endif>{{ __("Style 1") }}</option>
                            <option value="style-two" @if($footer_style == 'style-two') selected @endif>{{ __("Style 2") }}</option>
                            <option value="alternate" @if($footer_style == 'alternate') selected @endif>{{ __("Style 3") }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{__("Footer Info Contact")}}</label>
                    <div class="form-controls">
                        <div id="info_text_editor" class="ace-editor" style="height: 400px" data-theme="textmate" data-mod="html">{{setting_item_with_lang('footer_info_text',request()->query('lang'))}}</div>
                        <textarea class="d-none" name="footer_info_text" > {{ setting_item_with_lang('footer_info_text',request()->query('lang')) }} </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{__("Footer List Widget")}}</label>
                    <div class="form-controls">
                        <div class="form-group-item">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-3">{{__("Title")}}</div>
                                        <div class="col-md-2">{{__('Size')}}</div>
                                        <div class="col-md-6">{{__('Content')}}</div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="g-items">
                                    <?php
                                    $social_share = setting_item_with_lang('list_widget_footer',request()->query('lang'));
                                    if(!empty($social_share)) $social_share = json_decode($social_share,true);
                                    if(empty($social_share) or !is_array($social_share))
                                        $social_share = [];
                                    ?>
                                    @foreach($social_share as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" name="list_widget_footer[{{$key}}][title]" class="form-control" value="{{$item['title']}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control" name="list_widget_footer[{{$key}}][size]">
                                                        <option @if(!empty($item['size']) && $item['size']=='3') selected @endif value="3">1/4</option>
                                                        <option @if(!empty($item['size']) && $item['size']=='4') selected @endif value="4">1/3</option>
                                                        <option @if(!empty($item['size']) && $item['size']=='6') selected @endif value="6">1/2</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea name="list_widget_footer[{{$key}}][content]" rows="5" class="form-control">{{$item['content']}}</textarea>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-right">
                                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                                </div>
                                <div class="g-more hide">
                                    <div class="item" data-number="__number__">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" __name__="list_widget_footer[__number__][title]" class="form-control" value="">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control" __name__="list_widget_footer[__number__][size]">
                                                    <option value="3">1/4</option>
                                                    <option value="4">1/3</option>
                                                    <option value="6">1/2</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea __name__="list_widget_footer[__number__][content]" class="form-control" rows="5"></textarea>
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
                <div class="form-group">
                    <label>{{__("Copyright")}}</label>
                    <div class="form-controls">
                        <textarea name="copyright" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('copyright',request()->query('lang')) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{__("Footer Socials")}}</label>
                    <div class="form-controls">
                        <div id="footer_socials" class="ace-editor" style="min-height: 200px" data-theme="textmate" data-mod="html">{{setting_item_with_lang('footer_socials',request()->query('lang'))}}</div>
                        <textarea name="footer_socials" class="d-none">{{setting_item_with_lang('footer_socials',request()->query('lang')) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Page contact settings")}}</h3>
        <p class="form-group-desc">{{__('Settings for contact page')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label>{{__("List Contact")}}</label>
                    <div class="form-controls">
                        <div class="form-group-item">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-4">{{__("Title")}}</div>
                                        <div class="col-md-7">{{__('Info Contact')}}</div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="g-items">
                                    <?php
                                    $page_contact_lists = $settings['page_contact_lists'];
                                    if(!empty($page_contact_lists)) $page_contact_lists = json_decode($page_contact_lists,true);
                                    if(empty($page_contact_lists) or !is_array($page_contact_lists))
                                        $page_contact_lists = [];
                                    ?>
                                    @foreach($page_contact_lists as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" name="page_contact_lists[{{$key}}][title]" class="form-control" value="{{$item['title'] ?? ''}}">
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="">{{ __("Description") }}</label>
                                                    <textarea name="page_contact_lists[{{$key}}][desc]" class="form-control">{!! @clean($item['desc']) ?? '' !!}</textarea>
                                                    <label for="">{{ __("Icon") }}</label>
                                                    <div class="form-controls form-group-image">
                                                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('page_contact_lists['.$key.'][icon]',$item['icon'] ?? '') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-right">
                                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                                </div>
                                <div class="g-more hide">
                                    <div class="item" data-number="__number__">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">{{ __("Title") }}</label>
                                                <input type="text" __name__="page_contact_lists[__number__][title]" class="form-control" value="">
                                            </div>
                                            <div class="col-md-7">
                                                <label for="">{{ __("Description") }}</label>
                                                <textarea __name__="page_contact_lists[__number__][desc]" class="form-control"></textarea>
                                                <label for="">{{ __("Icon") }}</label>
                                                <div class="form-controls form-group-image">
                                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('page_contact_lists[__number__][icon]','','__name__') !!}
                                                </div>
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
                <div class="form-group">
                    <label class="">{{__("Iframe google map")}}</label>
                    <div class="form-controls">
                        <input type="text" class="form-control" name="page_contact_iframe_google_map" value="{{ $settings['page_contact_iframe_google_map'] ?? "" }}">
                    </div>
                </div>
                @if(is_default_lang())
                    <div class="form-group">
                        <label>{{__("Contact Call To Action")}}</label>
                        <div class="form-controls mb-3">
                            <input type="text" class="form-control" name="contact_call_to_action_title" placeholder="{{ __('Title') }}" value="{{ $settings['contact_call_to_action_title'] ?? "" }}">
                        </div>
                        <div class="form-controls mb-3">
                            <textarea name="contact_call_to_action_sub_title" class="form-control" placeholder="{{ __('Description') }}">{!! clean($settings['contact_call_to_action_sub_title'] ?? '') !!}</textarea>
                        </div>
                        <div class="form-controls mb-3">
                            <input type="text" class="form-control" name="contact_call_to_action_button_text" placeholder="{{ __('Button Text') }}" value="{{ $settings['contact_call_to_action_button_text'] ?? "" }}">
                        </div>
                        <div class="form-controls mb-3">
                            <input type="text" class="form-control" name="contact_call_to_action_button_link" placeholder="{{ __('Button Link') }}" value="{{ $settings['contact_call_to_action_button_link'] ?? "" }}">
                        </div>
                        <div class="form-controls form-group-image">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('contact_call_to_action_image',setting_item('contact_call_to_action_image')) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@section('script.body')
    <script src="{{asset('libs/ace/src-min-noconflict/ace.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        (function ($) {
            $('.ace-editor').each(function () {
                var editor = ace.edit($(this).attr('id'));
                editor.setTheme("ace/theme/"+$(this).data('theme'));
                editor.session.setMode("ace/mode/"+$(this).data('mod'));
                var me = $(this);

                editor.session.on('change', function(delta) {
                    // delta.start, delta.end, delta.lines, delta.action
                    me.next('textarea').val(editor.getValue());
                });
            });
        })(jQuery)
    </script>
@endsection
