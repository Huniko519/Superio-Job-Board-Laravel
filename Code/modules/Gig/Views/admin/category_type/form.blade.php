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
    <label class="control-label">{{__("Feature Image")}}</label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
</div>
<div class="form-group">
    <label class="control-label">{{__("Gig Category")}}</label>
    <select name="cat_id" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
        <?php
        $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
            foreach ($categories as $category) {
                if ($category->id == $row->id) {
                    continue;
                }
                $selected = '';
                if (old('cat_id',$row->cat_id) == $category->id)
                    $selected = 'selected';
                printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse(\Modules\Gig\Models\GigCategory::query()->withDepth()->having('depth', '=', 1)->get());
        ?>
    </select>
</div>
@endif
<div class="form-group">
    <label class="control-label">{{__("Status")}}</label>
    <select name="status" class="form-control">
        <option value="publish">{{__("Publish")}}</option>
        <option @if(old('status',$row->status) == 'draft') selected @endif value="draft">{{__("Draft")}}</option>
    </select>
</div>
