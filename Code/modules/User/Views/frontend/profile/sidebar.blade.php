<div class="profile-summary mb-2">
    <div class="profile-avatar">
        @if($avatar = $user->getAvatarUrl())
            <div class="avatar-img avatar-cover" style="background-image: url('{{$user->getAvatarUrl()}}')">
            </div>
        @else
            <span class="avatar-text">{{$user->getDisplayName()[0]}}</span>
        @endif
    </div>

    <h3 class="display-name">{{$user->getDisplayName()}}</h3>
    <p class="profile-since mt-1"><i class="flaticon-map-locator"></i> {{ __("From :from",["from"=> $user->country ]) }}</p>

    <p class="profile-since">{{ __("Member Since :time",["time"=> date("M Y",strtotime($user->created_at))]) }}</p>

    <button class="btn btn-success w-100 mt-2 d-none">{{ __("Contact Me") }}</button>
    <hr>

    <div class="meta-info">

        <div class="desc">
            <div class="title"> {{ __("Description") }}</div>
            <div class="text">
                {{ $user->bio }}
            </div>
        </div>
    </div>
</div>
