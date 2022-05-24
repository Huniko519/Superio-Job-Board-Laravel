@if($author = $row->author)
    <div class="profile-card mb-4">
        <div class="seller-card">
            <div class="profile-info">
                <div class="user-profile-image">
                    <label class="profile-pict w-100">
                        @if($avatar_url = $author->getAvatarUrl())
                            <img class="avatar" src="{{$avatar_url}}" alt="{{$author->getDisplayName()}}">
                        @else
                            <span class="s-avatar-text">{{ucfirst($author->getDisplayName()[0])}}</span>
                        @endif
                    </label>
                </div>
                <div class="user-profile-label">
                    <div class="username-line"><a href="{{ $author->getDetailUrl() }}" class="seller-link">{{ $author->getDisplayName()  }}</a></div>
                    <div class="one-liner-rating-wrapper"><p class="one-liner">{{ $author->address }}</p>
                    </div>
                    <button class="btn btn-sm mt-2 contact-me d-none">{{ __("Contact Me") }}</button>
                </div>
            </div>
            <div class="stats-desc">
                <ul class="user-stats">
                    <li>{{ __("From") }}<strong>{{ $author->country }}</strong></li>
                    <li>{{ __("Member since") }}<strong>{{ date_format($author->created_at , 'M Y') }}</strong></li>
                </ul>
                <article class="seller-desc">
                    <strong>{{ __("Description") }}</strong>
                    <div class="mt-2">
                        {{ $author->bio }}
                    </div>
                    <button class="read-more">{{ __("+ See More") }}</button>
                </article>
            </div>
        </div>
    </div>
@endif
