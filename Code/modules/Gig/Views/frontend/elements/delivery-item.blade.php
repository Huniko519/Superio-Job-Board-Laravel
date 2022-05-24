<div class="delivery-item user-message">
    <div class="delivery-heading">
        {{ __("DELIVERY") }} #{{ $delivery_count }}
    </div>
    <div class="delivery-body">
        <div class="activity-item">
            <div class="avatar type-image">
                {!! $activity->user->getUserAvatar('text') !!}
            </div>
            <div class="item-body">
                <div class="item-title">
                    @if(auth()->id() == $activity->user_id)
                        {{ __("Me") }}
                    @else
                        <a href="#">{{ $activity->user->getDisplayName() }}</a>
                    @endif
                </div>
                <div class="message-body">
                    {!! @clean($activity->content) !!}
                    @include('Gig::frontend.elements.attachments')
                </div>
            </div>
        </div>
    </div>
</div>
