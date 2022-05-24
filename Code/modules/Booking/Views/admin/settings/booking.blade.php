@if(is_default_lang())
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Guest Checkout')}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Enable guest checkout")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="booking_guest_checkout" value="1" @if(!empty($settings['booking_guest_checkout'])) checked @endif /> {{__("Yes, please")}} </label>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Checkout Page')}}</h3>
        <p class="form-group-desc">{{__('Change your checkout page options')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Enable reCapcha Booking Form")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="booking_enable_recaptcha" value="1" @if(!empty($settings['booking_enable_recaptcha'])) checked @endif /> {{__("On ReCapcha")}} </label>
                        <br>
                        <small class="form-text text-muted">{{__("Turn on the mode for booking form")}}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label >{{__("Terms & Conditions page")}}</label>
                    <div class="form-controls">
                        <?php
                            $template = !empty($settings['booking_term_conditions']) ? \Modules\Page\Models\Page::find($settings['booking_term_conditions'] ) : false;
                            \App\Helpers\AdminForm::select2('booking_term_conditions',[
                            'configs'=>[
                                    'ajax'=>[
                                        'url'=>url('/admin/module/page/getForSelect2'),
                                        'dataType'=>'json'
                                    ]
                                ]
                            ],
                            !empty($template->id) ? [$template->id,$template->title] :false
                            )
                        ?>
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
        <h3 class="form-group-title">{{__('Invoice Page')}}</h3>
        <p class="form-group-desc">{{__('Change your invoice page options')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <label>{{__("Invoice Logo")}}</label>
                        <div class="form-controls form-group-image">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('logo_invoice_id',$settings['logo_invoice_id'] ?? '') !!}
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="">{{__("Invoice Company Info")}}</label>
                    <div class="form-controls">
                        <textarea name="invoice_company_info" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('invoice_company_info',request()->query('lang')) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Other Settings')}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Why Book With Us?")}}</label>
                </div>
                <div class="form-group">
                    <div class="form-group-item">
                        <div class="form-group-item">
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-3">{{__("Title")}}</div>
                                    <div class="col-md-8">{{__('Class icon')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items">
                                @php $booking_why_book_with_us = setting_item_array('booking_why_book_with_us',[]); @endphp
                                @foreach($booking_why_book_with_us as $key=>$item)
                                    <div class="item" data-number="{{$key}}">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label>{{__("Title")}}</label>
                                                <div>
                                                    <input type="text" name="booking_why_book_with_us[{{$key}}][title]" placeholder="{{ __("Customer care available 24/7") }}" class="form-control" value="{{$item['title'] ?? ""}}">
                                                    <input type="text" name="booking_why_book_with_us[{{$key}}][link]" placeholder="{{ __("#") }}" class="form-control" value="{{$item['link'] ?? ""}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>{{__("Icon")}}</label>
                                                <div>
                                                    <input type="text" name="booking_why_book_with_us[{{$key}}][icon]"placeholder="fa fa-phone" class="form-control" value="{{$item['icon'] ?? ""}}">
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
                                        <div class="col-md-7">
                                            <label>{{__("Title - Link info")}}</label>
                                            <div>
                                                <input type="text" __name__="booking_why_book_with_us[__number__][title]" placeholder="{{ __("Customer care available 24/7") }}" class="form-control" value="">
                                                <input type="text" __name__="booking_why_book_with_us[__number__][link]" placeholder="{{ __("#") }}" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__("Icon")}}</label>
                                            <div>
                                                <input type="text" __name__="booking_why_book_with_us[__number__][icon]"placeholder="fa fa-phone" class="form-control" value="">
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
        </div>
    </div>
</div>

