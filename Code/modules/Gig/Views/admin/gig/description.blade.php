<div class="form-group row">
    <label class="control-label col-md-3 text-right col-form-label">{{__('Briefly Describe Your Gig')}}</label>
    <div class="col-md-9">
        <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
    </div>
</div>
<div class="form-group-item row mt-3">
    <label class="control-label col-md-3 text-right col-form-label">{{__('Frequently Asked Questions')}}</label>
    <div class="col-md-9">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-11">{{__("Add Questions & Answers for Your Buyers.")}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $old = old('faqs',$row->faqs ?? []);
            if(empty($old)) $old = [[]];
            ?>
            @if(!empty($old))
                @foreach($old as $key=>$faq)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="text" name="faqs[{{$key}}][title]" class="form-control" value="{{$faq['title'] ?? ''}}" placeholder="{{__('Add a Question: i.e. Do you translate to English as well?')}}">
                                <textarea name="faqs[{{$key}}][content]" class="form-control" placeholder="{{__('Add an Answer: i.e. Yes, I also translate from English to Hebrew.')}}">{{$faq['content'] ?? ''}}</textarea>
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
            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add FAQ')}}</span>
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-11">
                        <input type="text" __name__="faqs[__number__][title]" class="form-control" placeholder="{{__('Add a Question: i.e. Do you translate to English as well?')}}">
                        <textarea __name__="faqs[__number__][content]" class="form-control" placeholder="{{__('Add an Answer: i.e. Yes, I also translate from English to Hebrew.')}}"></textarea>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
