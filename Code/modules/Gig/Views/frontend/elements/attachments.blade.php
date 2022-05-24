@if($activity->file_ids && count($activity->files()) > 0)
    <div class="activity-attachments">
        <h4 class="a-title">{{ __("ATTACHMENTS") }}</h4>
        <div class="list-files">
            @foreach($activity->files() as $file)
                <div class="attach-item">
                    <a href="{{ get_file_url($file->id, 'full') }}" title="{{ $file->file_name }}.{{ $file->file_extension }}" target="_blank" >
                        <div class="thumb">
                            <img src="{{ $file->getThumbIcon() }}" alt="{{ $file->file_name }}" />
                        </div>
                        <div class="caption">
                            <span class="f-name">{{ $file->file_name }}</span>.{{ $file->file_extension }}
                            <span class="f-size">({{ convert_file_size($file->file_size) }})</span>
                            <span class="down-icon"><i class="la la-download"></i></span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
