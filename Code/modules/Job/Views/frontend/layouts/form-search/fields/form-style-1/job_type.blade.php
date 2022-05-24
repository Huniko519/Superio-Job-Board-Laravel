<!-- Switchbox Outer -->
@if($job_types)
    <div class="switchbox-outer">
        <h4>{{ $val['title'] }}</h4>
        <ul class="switchbox">
            @foreach($job_types as $type)
                @php
                    $translation = $type->translateOrOrigin(app()->getLocale());
                    @endphp
                <li>
                    <label class="switch">
                        <input type="checkbox" name="job_type[]" value="{{ $type->id  }}" @if(!empty(request()->get('job_type')) && in_array($type->id, request()->get('job_type'))) checked @endif>
                        <span class="slider round"></span>
                        <span class="title">{{ $translation->name }}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
@endif
