<!-- Job Block -->
@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp

<div class="inner-box">
    <span class="thumb"><img src="{{$row->user->getAvatarUrl()}}" alt="{{ $row->user->getDisplayName()}}"></span>
    <h3 class="name"><a href="{{ $row->getDetailUrl() }}">{{ $row->user->getDisplayName() }}</a></h3>
    <span class="cat">{{$row->title}}</span>
    <ul class="job-info">
        @if($row->city || $row->country)
            <li><span class="icon flaticon-map-locator"></span> {{$row->city}}, {{$row->country}}</li>
        @endif
        @if($row->expected_salary)
            <li><span class="icon flaticon-money"></span> {{$row->expected_salary}} {{currency_symbol()}}  / {{$row->salary_type}}</li>
        @endif
    </ul>
    <ul class="post-tags">
        @if(!empty($row->categories))
            @foreach($row->categories as $oneCategory)
                @php $t = $oneCategory->translateOrOrigin(app()->getLocale()); @endphp
                <li><a href="{{ route('candidate.index', ['category' => $oneCategory->id]) }}">{{$t->name}}</a></li>
            @endforeach
        @endif
    </ul>
    <a href="{{ $row->getDetailUrl() }}" class="theme-btn btn-style-three"><span class="btn-title">{{__('View Profile')}}</span></a>
</div>
