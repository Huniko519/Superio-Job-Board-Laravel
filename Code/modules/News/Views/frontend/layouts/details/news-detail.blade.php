@php $translation = $row->translateOrOrigin(app()->getLocale());
    $user = \Modules\User\Models\User::find($row->create_user);
@endphp
<div class="auto-container">
    <div class="upper-box">
        <h3>{{ $translation->title }}</h3>
        <ul class="post-info">
            <li>
                @if(!empty($user))
                    <span class="thumb">
                        <img src="{{ $user->getAvatarUrl() }}" alt="{{$user->getDisplayName() ?? ''}}">
                    </span>
                @endif
                {{ $user->getDisplayName() }}
            </li>
            <li>{{ display_date($row->updated_at) }}</li>
        </ul>
    </div>
</div>
<div class="main-image">
    {!! get_image_tag($row->banner_id,'full',['alt' => $translation->title]) !!}
</div>
<div class="auto-container">
    <div class="blog-content">
        <p class="mb-0 text-lh-lg">
            {!! $translation->content !!}
        </p>

        <div class="other-options">
            <div class="social-share">
                <h5>{{ __('Share this post') }}</h5>
                <a class="facebook share-item" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Facebook")}}"><i class="fab fa-facebook-f"></i>{{ __('Facebook') }}</a>
                <a class="twitter share-item" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Twitter")}}"><i class="fab fa-twitter"></i> {{ __('Twitter') }}</a>
                <a class="google share-item" href="https://plus.google.com/share?url={{$row->getDetailUrl()}}" target="_blank" original-title="{{__("Google+")}}"><i class="fab fa-google"></i> {{__("Google+")}}</a>
            </div>

            <div class="tags">
                @if($row->getTags())
                    @foreach($row->getTags() as $tag)
                        <a href="{{ $tag->getDetailUrl() }}">{{ $tag->name }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        @if(!empty($near_post))
            <div class="post-control d-block overflow-hidden">
                @foreach($near_post as $post)
                    @php $translation = $post->translateOrOrigin(app()->getLocale()); @endphp
                    @if($post->id < $row->id)
                        <div class="prev-post float-left">
                            <span class="icon flaticon-back"></span>
                            <span class="title">{{ __('Previous Post') }}</span>
                            <h5><a href="{{ $post->getDetailUrl() }}">{{ $translation->title ?? '' }}</a></h5>
                        </div>
                    @endif

                    @if($post->id > $row->id)
                        <div class="next-post float-right">
                            <span class="icon flaticon-next"></span>
                            <span class="title">{{ __('Next Post') }}</span>
                            <h5><a href="{{ $post->getDetailUrl() }}">{{ $translation->title ?? '' }}</a></h5>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{--Reviews--}}
        @if(setting_item('news_enable_review'))
            @php $review_score = $row->review_data @endphp
            <div id="reviews" class="blog-reviews">
                @include('Review::frontend.form')
            </div>
        @endif
    </div>
</div>
