<div class="newsletter-form wow fadeInUp style-eight">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>
        <form method="post" action="{{ route('newsletter.subscribe') }}" class="bravo-subscribe-form">
            {{csrf_field()}}
            <div class="form-group">
                <div class="form-mess"></div>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="email" value="" placeholder="Your e-mail" required>
                <button type="submit" id="subscribe-newslatters" class="theme-btn btn-style-one">{{ $button_name }}
                    <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>
</div>
