<!-- Job Skills -->
@if($row->skills)
<h4 class="widget-title">{{ __("Job Skills") }}</h4>
<div class="widget-content">
    <ul class="job-skills">
        @foreach($row->skills as $skill)
            @php $skill_translation = $skill->translateOrOrigin(app()->getLocale()) @endphp
            <li><a>{{ $skill_translation->name }}</a></li>
        @endforeach
    </ul>
</div>
@endif
