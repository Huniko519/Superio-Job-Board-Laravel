<div class="btn-box">
    @if($row->isOpen())
        @switch($row->apply_type)
            @case('email')
                <a href="mailto:{{ $row->apply_email ?? ($row->company->email ?? '') }}" target="_blank" rel="nofollow" class="theme-btn btn-style-one">{{ __("Apply For Job") }}</a>
                @break
            @case('external')
                <a href="{{ $row->apply_link }}" target="_blank" rel="nofollow" class="theme-btn btn-style-one">{{ __("Apply For Job") }}</a>
                @break
            @default
                @if(!auth()->check())
                    <a href="#" class="theme-btn btn-style-one bc-call-modal login">{{ __("Apply For Job") }}</a>
                @else
                    @if($applied)
                        <a href="javascript:void(0)" class="theme-btn btn-style-one bc-apply-job-button">{{ __("Applied") }}</a>
                    @else
                        @if($candidate and !empty($check_apply_job = $candidate->check_maximum_apply_job()))
                            <div class="text-danger apply-out">{{ $check_apply_job['mess'] }}</div>
                        @else
                            <a href="#" data-require-text="{{ __('Please login as "Candidate" to apply') }}" class="theme-btn btn-style-one bc-apply-job-button @if(!is_candidate() || empty($candidate)) bc-require-candidate-apply @else bc-call-modal apply-job @endif">{{ __("Apply For Job") }}</a>
                        @endif
                    @endif
                    @include('Job::frontend.layouts.details.apply-job-popup')
                @endif
            @break
        @endswitch
    @else
        <div class="text-danger job-expired">{{ __("Job expired!") }}</div>
    @endif
    <button class="bookmark-btn service-wishlist @if($row->wishlist) active @endif" data-id="{{$row->id}}" data-type="{{$row->type}}"><i class="flaticon-bookmark"></i></button>
</div>
