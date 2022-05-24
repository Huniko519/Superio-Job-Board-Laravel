<div class="form-group-item row mt-3">
    <div class="col-md-12">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-11">{{__("Add Question")}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $old = old('requirements',$row->requirements ?? []);
            if(empty($old)) $old = [];
            ?>
            @if(!empty($old))
                @foreach($old as $key=>$rq)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-9">
                                <textarea name="requirements[{{$key}}][content]" class="form-control" placeholder="{{__('Request necessary details such as dimensions, brand guidelines, and more.')}}">{{$rq['content'] ?? ''}}</textarea>
                            </div>
                            <div class="col-md-2">
                                <label ><input type="checkbox" @if($rq['required'] ?? '') checked @endif name="requirements[{{$key}}][required]"  value="1" > {{__("Required")}}</label>
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
            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add question')}}</span>
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-9">
                        <textarea __name__="requirements[__number__][content]" class="form-control" placeholder="{{__('Request necessary details such as dimensions, brand guidelines, and more.')}}"></textarea>
                    </div>
                    <div class="col-md-2">
                        <label ><input type="checkbox" __name__="requirements[__number__][required]"  value="1" > {{__("Required")}}</label>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
