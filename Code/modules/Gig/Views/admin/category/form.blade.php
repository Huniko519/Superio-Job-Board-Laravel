<div class="form-group">
    <label>{{__("Name")}} <span class="text-danger">*</span></label>
    <input type="text" required value="{{old('name',$translation->name)}}" placeholder="{{__("Category name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Short description")}} </label>
    <input type="text" value="{{old('content',$translation->content)}}" placeholder="{{__("Short description")}}" name="content" class="form-control">
</div>
@if(is_default_lang())
    <div class="form-group">
        <label>{{__("Parent")}}</label>
        <select name="parent_id" class="form-control">
            <option value="">{{__("-- Please Select --")}}</option>
            <?php
            $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
                foreach ($categories as $category) {
                    if ($category->id == $row->id) {
                        continue;
                    }
                    $selected = '';
                    if (old('parent_id',$row->parent_id) == $category->id)
                        $selected = 'selected';
                    printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                    $traverse($category->children, $prefix . '-');
                }
            };
            $traverse($parents);
            ?>
        </select>
    </div>

<div class="form-group">
    <label class="control-label">{{__("Feature Image")}}</label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
</div>
<div class="form-group">
    <label class="control-label">{{__("Related News Category")}}</label>
    <select name="news_cat_id" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
        <?php
        $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
            foreach ($categories as $category) {
                if ($category->id == $row->id) {
                    continue;
                }
                $selected = '';
                if (old('news_cat_id',$row->news_cat_id) == $category->id)
                    $selected = 'selected';
                printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse(\Modules\News\Models\NewsCategory::query()->get()->toTree());
        ?>
    </select>
</div>
@endif
<div class="form-group-item mt-3">
    <label class="control-label">{{__('FAQS')}}</label>
    <div class="">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-11">{{__("FAQ")}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $old = old('faqs',$translation->faqs ?? []);
            ?>
            @if(!empty($old))
                @foreach($old as $key=>$faq)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="faqs[{{$key}}][title]" class="form-control" value="{{$faq['title'] ?? ''}}" placeholder="{{__('Add a Question')}}">
                                <textarea name="faqs[{{$key}}][content]" class="form-control" placeholder="{{__('Add an Answer')}}">{{$faq['content'] ?? ''}}</textarea>
                            </div>
                            <div class="col-md-2">
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
                    <div class="col-md-10">
                        <input type="text" __name__="faqs[__number__][title]" class="form-control" placeholder="{{__('Add a Question:')}}">
                        <textarea __name__="faqs[__number__][content]" class="form-control" placeholder="{{__('Add an Answer:')}}"></textarea>
                    </div>
                    <div class="col-md-2">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label">{{__("Status")}}</label>
    <select name="status" class="form-control">
        <option value="publish">{{__("Publish")}}</option>
        <option @if(old('status',$row->status) == 'draft') selected @endif value="draft">{{__("Draft")}}</option>
    </select>
</div>
