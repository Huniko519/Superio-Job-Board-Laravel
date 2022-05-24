@if(!empty($row->company))
    @php $company_translation = $row->company->translateOrOrigin(app()->getLocale()); @endphp
    <div class="sidebar-widget company-widget company-v2">
        <div class="widget-content">
            <div class="company-title">
                @if(!empty($row->company->avatar_id))
                    <div class="company-logo">
                        <a href="{{ $row->company->getDetailUrl() }}"><img src="{{ \Modules\Media\Helpers\FileHelper::url($row->company->avatar_id) }}" alt="{{ $company_translation->name }}"></a>
                    </div>
                @endif
                <h5 class="company-name"><a style="color:inherit" href="{{ $row->company->getDetailUrl() }}">{{ $company_translation->name }}</a></h5>
                <a href="{{ $row->company->getDetailUrl() }}" class="profile-link">{{ __("View company profile") }}</a>
            </div>
        </div>
    </div>
@endif
