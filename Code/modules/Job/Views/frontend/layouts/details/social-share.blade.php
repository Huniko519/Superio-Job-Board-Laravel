<!-- Other Options -->
<div class="other-options">
    <div class="social-share">
        <h5>{{ __("Share this job") }}</h5>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $row->getDetailUrl() }}&amp;title={{ $translation->title }}" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i> {{ __("Facebook") }}</a>
        <a href="https://twitter.com/share?url={{ $row->getDetailUrl() }}&amp;title={{ $translation->title }}" target="_blank" class="twitter"><i class="fab fa-twitter"></i> {{ __("Twitter") }}</a>
        <a href="http://pinterest.com/pin/create/button/?url={{ $row->getDetailUrl() }}&description={{ $translation->title }}" target="_blank" class="google"><i class="fab fa-pinterest"></i> {{ __("Pinterest") }}</a>
    </div>
</div>
