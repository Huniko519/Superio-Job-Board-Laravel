<?php  $languages = \Modules\Language\Models\Language::getActive();
$packages = old('packages',$translation->packages);
?>
<div class="form-group-item row" >
    <label class="control-label col-md-3 text-right col-form-label">{{__('Packages')}}</label>
    <div class="col-md-9">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-3">{{__("Basic")}}</div>
                <div class="col-md-3">{{__("Standard")}}</div>
                <div class="col-md-3">{{__("Premium")}}</div>
            </div>
        </div>
        <div class="g-items">
            <div class="item">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <strong>{{__(" Name")}} <span class="text-danger">*</span></strong>
                    </div>
                    <div class="col-md-3">
                        <input type="text" required name="packages[0][name]" class="form-control" value="{{$packages[0]['name'] ?? 'Basic'}}" placeholder="{{__('Name your package')}}">
                        <input type="hidden" name="packages[0][key]" value="basic">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="packages[1][name]" class="form-control" value="{{$packages[1]['name'] ?? 'Standard'}}" placeholder="{{__('Name your package')}}">
                        <input type="hidden" name="packages[1][key]" value="standard">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="packages[2][name]" class="form-control" value="{{$packages[2]['name'] ?? 'Premium'}}" placeholder="{{__('Name your package')}}">
                        <input type="hidden" name="packages[2][key]" value="premium">
                    </div>
                </div>
            </div>
            @if(is_default_lang())
                <div class="item">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <strong>{{__("Price")}} <span class="text-danger">*</span></strong>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="any" name="basic_price" min="5" class="form-control" required value="{{$row->basic_price}}" placeholder="{{__('Package Price')}}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="any" name="standard_price" class="form-control" value="{{$row->standard_price}}" placeholder="{{__('Package Price')}}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="any" name="premium_price" class="form-control" value="{{$row->premium_price}}" placeholder="{{__('Package Price')}}">
                        </div>
                    </div>
                </div>
            @endif
            <div class="item">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <strong>{{__("Desc")}} <span class="text-danger">*</span></strong>
                    </div>
                    <div class="col-md-3">
                        <textarea name="packages[0][desc]" class="form-control" required placeholder="{{__('Describe the details of your offering')}}" cols="30" rows="6">{{$packages[0]['desc'] ?? ''}}</textarea>
                    </div>
                    <div class="col-md-3">
                        <textarea name="packages[1][desc]" class="form-control" placeholder="{{__('Describe the details of your offering')}}" cols="30" rows="6">{{$packages[1]['desc'] ?? ''}}</textarea>
                    </div>
                    <div class="col-md-3">
                        <textarea name="packages[2][desc]" class="form-control" placeholder="{{__('Describe the details of your offering')}}" cols="30" rows="6">{{$packages[2]['desc'] ?? ''}}</textarea>
                    </div>
                </div>
            </div>
            @if(is_default_lang())
                <div class="item">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <strong>{{__("Delivery Time")}} <span class="text-danger">*</span></strong>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[0][delivery_time]" required class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[0]['delivery_time'] ?? '') == $i) selected @endif value="{{$i}}">{{__(":count Day(s)",['count'=>$i])}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[1][delivery_time]" class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[1]['delivery_time'] ?? '') == $i) selected @endif value="{{$i}}">{{__(":count Day(s)",['count'=>$i])}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[2][delivery_time]" class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[2]['delivery_time'] ?? '') == $i) selected @endif value="{{$i}}">{{__(":count Day(s)",['count'=>$i])}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <strong>{{__("Revisions")}} <span class="text-danger">*</span></strong>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[0][revision]" required class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[0]['revision'] ?? '') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                                <option value="-1">{{__("Unlimited")}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[1][revision]" class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[1]['revision'] ?? '') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                                <option value="-1">{{__("Unlimited")}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="packages[2][revision]" class="form-control">
                                <option value="">{{__("-- Please Select --")}}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if(($packages[2]['revision'] ?? '') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                                <option value="-1">{{__("Unlimited")}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="form-group-item row">
    <label class="control-label col-md-3 text-right col-form-label">{{__('Package Compare')}}</label>
    <div class="col-md-9">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-5">{{__("Name")}}</div>
                <div class="col-md-2">{{__('Basic')}}</div>
                <div class="col-md-2">{{__('Standard')}}</div>
                <div class="col-md-2">{{__('Premium')}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $old = old('package_compare',$translation->package_compare ?? []);
            if(empty($old)) $old = [[]];
            ?>
            @if(!empty($old))
                @foreach($old as $key=>$extra_price)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-5">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" name="package_compare[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$extra_price['name'.$key_lang] ?? ''}}" placeholder="{{__('Attribute Name')}}">
                                        </div>
                                    @endforeach
                                @else
                                    <input type="text" name="package_compare[{{$key}}][name]" class="form-control" value="{{$extra_price['name'] ?? ''}}" placeholder="{{__('Attribute Name')}}">
                                @endif
                            </div>
                            <div class="col-md-2">
                                <input type="text"  name="package_compare[{{$key}}][content]" class="form-control" value="{{$extra_price['content'] ?? ''}}">
                            </div>
                            <div class="col-md-2">
                                <input type="text"  name="package_compare[{{$key}}][content1]" class="form-control" value="{{$extra_price['content1'] ?? ''}}">
                            </div>
                            <div class="col-md-2">
                                <input type="text"  name="package_compare[{{$key}}][content2]" class="form-control" value="{{$extra_price['content2'] ?? ''}}">
                            </div>
                            <div class="col-md-1">
                                @if(is_default_lang())
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            @if(is_default_lang())
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            @endif
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
                                    <input type="text" __name__="package_compare[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Attribute name')}}">
                                </div>
                            @endforeach
                        @else
                            <input type="text" __name__="package_compare[__number__][name]" class="form-control" value="" placeholder="{{__('Attribute Name')}}">
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input type="text" __name__="package_compare[__number__][content]" class="form-control" value="">
                    </div>
                    <div class="col-md-2">
                        <input type="text" __name__="package_compare[__number__][content1]" class="form-control" value="">
                    </div>
                    <div class="col-md-2">
                        <input type="text" __name__="package_compare[__number__][content2]" class="form-control" value="">
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group-item row mt-3">
    <label class="control-label col-md-3 text-right col-form-label">{{__('Add Extra Services')}}</label>
    <div class="col-md-9">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-5">{{__("Name")}}</div>
                <div class="col-md-3">{{__('Price')}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $old = old('extra_price',$row->extra_price ?? []);
            if(empty($old)) $old = [[]];
            ?>
            @if(!empty($old))
                @foreach($old as $key=>$extra_price)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-6">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" name="extra_price[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$extra_price['name'.$key_lang] ?? ''}}" placeholder="{{__('Extra price name')}}">
                                        </div>
                                    @endforeach
                                @else
                                    <input type="text" name="extra_price[{{$key}}][name]" class="form-control" value="{{$extra_price['name'] ?? ''}}" placeholder="{{__('Extra price name')}}">
                                @endif
                            </div>
                            <div class="col-md-5">
                                <input type="number" @if(!is_default_lang()) disabled @endif min="0" name="extra_price[{{$key}}][price]" class="form-control" value="{{$extra_price['price'] ?? ''}}">
                            </div>
                            <div class="col-md-1">
                                @if(is_default_lang())
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            @if(is_default_lang())
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            @endif
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-6">
                        @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                            @foreach($languages as $language)
                                <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                <div class="g-lang">
                                    <div class="title-lang">{{$language->name}}</div>
                                    <input type="text" __name__="extra_price[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Extra price name')}}">
                                </div>
                            @endforeach
                        @else
                            <input type="text" __name__="extra_price[__number__][name]" class="form-control" value="" placeholder="{{__('Extra price name')}}">
                        @endif
                    </div>
                    <div class="col-md-5">
                        <input type="number" min="0" __name__="extra_price[__number__][price]" class="form-control" value="">
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
