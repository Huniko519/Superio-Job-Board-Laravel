@if($row->banner_image_id)
    @php
        $data = [
            'bg_image_url'  =>  get_file_url($row->banner_image_id,'full'),
            'title'         =>  $translation->name,
            'sub_title'     =>  $translation->sub_title
        ];
    @endphp
    @include('Template::frontend.blocks.form-search-all-service.style_1',$data)
@endif

