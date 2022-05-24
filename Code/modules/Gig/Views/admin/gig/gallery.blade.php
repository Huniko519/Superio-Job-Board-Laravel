<div class="form-group">
    <label class="control-label">{{__("Feature Image")}}</label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
</div>
<div class="form-group">
    <label class="control-label">{{__("Gallery")}}</label>
    {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
</div>
<div class="form-group">
    <label class="control-label">{{__("Youtube Video")}}</label>
    <input type="text" name="video_url" class="form-control" value="{{old('video_url',$row->video_url)}}" placeholder="{{__("Youtube link video")}}">
</div>
