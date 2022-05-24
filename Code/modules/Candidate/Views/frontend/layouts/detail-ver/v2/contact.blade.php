
<div class="sidebar-widget contact-widget">
    <h4 class="widget-title">{{__('Contact Us')}}</h4>
    <div class="widget-content">
        <!-- Comment Form -->
        <div class="default-form">
            <!--Comment Form-->
            <form method="post" action="{{ route("company.contact.store") }}"  class="bravo-contact-block-form">
                <input type="hidden" name="origin_id" value="{{$origin_id}}">
                <input type="hidden" name="contact_to" value="company">
                @if(!empty($job_id))
                    <input type="hidden" name="object_id" value="{{ $job_id }}">
                    <input type="hidden" name="object_model" value="job">
                @endif
                {{csrf_field()}}
                <div style="display: none;">
                    <input type="hidden" name="g-recaptcha-response" value="">
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <input type="text" name="name" placeholder="{{__('Your Name')}}" required>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <input type="email" name="email" placeholder="{{__('Email Address')}}" required>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <textarea class="darma" name="message" placeholder="{{__('Message')}}"></textarea>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        {{recaptcha_field('contact')}}
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <button class="theme-btn btn-style-one" type="submit" name="submit-form">{{__('Send Message')}}</button>
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="form-mess"></div>
                </div>
            </form>
        </div>
    </div>
</div>
