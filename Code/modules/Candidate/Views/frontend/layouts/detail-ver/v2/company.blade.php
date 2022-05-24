@if(!empty($row->company))
    <div class="sidebar-widget company-widget company-v2">
        <div class="widget-content">
            <div class="company-title">
                @if(!empty($row->company->avatar_id))
                    <div class="company-logo">
                        <img src="{{ \Modules\Media\Helpers\FileHelper::url($row->company->avatar_id) }}" alt="{{ $row->company->name }}">
                    </div>
                @endif
                <h5 class="company-name">{{ $row->company->name }}</h5>
                <a href="{{ $row->company->getDetailUrl() }}" class="profile-link">{{ __("View company profile") }}</a>
            </div>
        </div>
    </div>
@endif
