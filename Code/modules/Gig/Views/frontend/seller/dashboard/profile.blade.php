<div class="profile-summary mb-2">
    <div class="seller-data">
        <div class="profile-avatar">
            @if($avatar_url = $auth->getAvatarUrl())
                <img class="avatar" src="{{$avatar_url}}" alt="{{$auth->getDisplayName()}}">
            @else
                <span class="avatar s-avatar-text">{{ucfirst($auth->getDisplayName()[0])}}</span>
            @endif
        </div>
        <h3 class="display-name">{{ $auth->name }}</h3>
        @if($auth->address)
            <p class="profile-since mt-1"><i class="flaticon-map-locator"></i> {{ $auth->address }}</p>
        @endif

    </div>
    <div class="seller-info">
        <div class="meta-info">
            <div class="desc">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-user pr-2" aria-hidden="true"></i>{{__("Member Since")}}</span>
                        <span class="badge-pill">{{ date_format($auth->created_at , 'M Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-gift pr-2" aria-hidden="true"></i>{{__("Gig")}}</span>
                        <span class="badge-pill">{{ number_format($count_gig) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-shopping-cart pr-2" aria-hidden="true"></i>{{__("Order")}}</span>
                        <span class="badge-pill">{{ number_format($rows->total()) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
