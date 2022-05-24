<div class="form-group row">
    <div class="col-md-3 col-form-label text-right"><label>{{__("Title")}} <span class="text-danger">*</span></label></div>
    <div class="col-md-9">
        <input type="text" value="{{old('title',$translation->title)}}" required placeholder="{{__("Name of the gig")}}" name="title" class="form-control">
    </div>
</div>
@if(is_default_lang())
<div class="form-group row ">
    <label class="control-label col-md-3 col-form-label text-right">{{__("Category")}} <span class="text-danger">*</span></label>
    <div class="col-md-3">
        <select @if(!is_default_lang()) readonly @endif name="cat_id" required class="form-control">
            <option value="">{{__("-- Select a Category--")}}</option>
            <?php
            $items = \Modules\Gig\Models\GigCategory::query()->whereNull('parent_id')->get();
            ?>
            @foreach($items as $item)
                <option @if(old('cat_id',$row->cat_id) == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select @if(!is_default_lang()) readonly @endif name="cat2_id" required class="form-control">
            <option value="">{{__("-- Select a Subcategory --")}}</option>
            <?php
            $items = \Modules\Gig\Models\GigCategory::query()->withDepth()->having('depth', '=', 1)->get();
            ?>
            @foreach($items as $item)
                <option data-parent="{{$item->parent_id}}" @if(old('cat2_id',$row->cat2_id) == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select @if(!is_default_lang()) readonly @endif name="cat3_id" required class="form-control">
            <option value="">{{__("-- Select a Subject--")}}</option>
            <?php
            $items = \Modules\Gig\Models\GigCategory::query()->withDepth()->having('depth', '=', 2)->get();
            ?>
            @foreach($items as $item)
                <option data-parent="{{$item->parent_id}}" @if(old('cat3_id',$row->cat3_id) == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="control-label col-md-3 col-form-label text-right">{{__("Search Tags")}}</label>
    <div class="col-md-9">
        <div class="">
            <input type="text" data-role="tagsinput" value="{{$row->tag}}" placeholder="{{ __('Enter tag')}}" name="tag" class="form-control tag-input">
            <br>
            <div class="show_tags">
                <?php
                ?>
                @if(!empty($tags))
                    @foreach($tags as $tag)
                        <span class="tag_item">{{$tag->name}}<span data-role="remove"></span>
                                                <input type="hidden" name="tag_ids[]" value="{{$tag->id}}">
                                            </span>
                    @endforeach
                @endif
            </div>
        </div>
        <p class="text-right"><small>{{__("10 tags maximum")}}</small></p>
    </div>
</div>
@endif
