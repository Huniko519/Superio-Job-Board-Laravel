<!-- Job Block -->
@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    $view_profile = (!empty($hide_profile)) ? 0 : 1;
@endphp
<div class="inner-box">
    <div class="content">

        <figure class="image"><img src="{{$row->user->getAvatarUrl()}}" alt="{{ $row->user->getDisplayName()}}"></figure>

        <h4 class="name"><a href="{{ $row->getDetailUrl() }}">{{ $row->user->getDisplayName() }}</a></h4>
        <ul class="candidate-info">
            @if($row->title)
                <li class="designation">{{$row->title}}</li>
            @endif
            @if($row->city)
                <li><span class="icon flaticon-map-locator"></span> {{$row->city}}</li>
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
    </div>

    @if($view_profile)
        <div class="btn-box">
            <button class="bookmark-btn service-wishlist @if($row->wishlist) active @endif" data-id="{{$row->id}}" data-type="{{$row->type}}"><span class="flaticon-bookmark"></span></button>
            <a href="{{ $row->getDetailUrl() }}" class="theme-btn btn-style-three"><span class="btn-title">{{__('View Profile')}}</span></a>
        </div>
    @endif
</div>
