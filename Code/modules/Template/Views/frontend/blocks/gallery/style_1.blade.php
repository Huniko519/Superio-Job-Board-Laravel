<div class="gallery about-section-three pb-0">
    <div class="auto-container">
        <div class="images-box">
            <div class="row">
                @if(!empty($list_item))
                    @foreach($list_item as $item)
                        <div class="column col-lg-3 col-md-6 col-sm-6">
                            @if(!empty($item))
                                @foreach($item as $k => $img)
                                     <figure class="image">
                                        <img src="{{ get_file_url($img['image_id'],'full') }}" alt="{{ __('About') }}">
                                    </figure>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
