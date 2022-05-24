<div class="sidebar-widget">
    <div class="widget-content">
        <ul class="job-overview">
            @if($row->experience_year)
                <li>
                    <i class="icon icon-calendar"></i>
                    <h5>{{__('Experience')}}:</h5>
                    <span>{{$row->experience_year}} {{__('Years')}}</span>
                </li>
            @endif
            @if(!empty($row->user->birthday))
                <li>
                    <i class="icon icon-expiry"></i>
                    <h5>{{__('Birthday')}}:</h5>
                    <span>{{ !empty($row->user->birthday) ? display_date($row->user->birthday) : '' }}</span>
                </li>
            @endif

            @if($row->expected_salary)
                <li>
                    <i class="icon icon-salary"></i>
                    <h5>{{__('Expected Salary')}}:</h5>
                    <span>{{$row->expected_salary}} {{currency_symbol()}} / {{$row->salary_type}}</span>
                </li>
            @endif

            @if($row->gender)
                <li>
                    <i class="icon icon-user-2"></i>
                    <h5>{{__('Gender')}}:</h5>
                    <span>{{ ucfirst(__($row->gender)) }}</span>
                </li>
            @endif

            @if($row->languages)
                <li>
                    <i class="icon icon-language"></i>
                    <h5>{{__('Language')}}:</h5>
                    <span>{{ $row->languages }}</span>
                </li>
            @endif

            @if($row->education_level)
                <li>
                    <i class="icon icon-degree"></i>
                    <h5>{{__('Education Level')}}:</h5>
                    <span>{{ ucfirst(__($row->education_level)) }}</span>
                </li>
            @endif

        </ul>
    </div>

</div>

<div class="sidebar-widget social-media-widget">
    <h4 class="widget-title">{{__('Social media')}}</h4>
    <div class="widget-content">
        <div class="social-links">
            <?php
            $socialMediaData = @$row->social_media;
            ?>
            @if(!empty(@$socialMediaData['facebook']))
                <a target="_blank" href="{{$socialMediaData['facebook']}}"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if(!empty(@$socialMediaData['twitter']))
                <a target="_blank" href="{{$socialMediaData['twitter']}}"><i class="fab fa-twitter"></i></a>
            @endif
            @if(!empty(@$socialMediaData['instagram']))
                <a target="_blank" href="{{$socialMediaData['instagram']}}"><i class="fab fa-instagram"></i></a>
            @endif
            @if(!empty(@$socialMediaData['pinterest']))
                <a target="_blank" href="{{$socialMediaData['pinterest']}}"><i class="fab fa-pinterest"></i></a>
            @endif
            @if(!empty(@$socialMediaData['dribbble']))
                <a target="_blank" href="{{$socialMediaData['dribbble']}}"><i class="fab fa-dribbble"></i></a>
            @endif
            @if(!empty(@$socialMediaData['google']))
                <a target="_blank" href="{{$socialMediaData['google']}}"><i class="fab fa-google"></i></a>
            @endif
            @if(!empty(@$socialMediaData['linkedin']))
                <a target="_blank" href="{{$socialMediaData['linkedin']}}"><i class="fab fa-linkedin-in"></i></a>
            @endif
        </div>
    </div>
</div>

@if(!empty($row->skills) && count($row->skills) > 0)
    <div class="sidebar-widget">
        <!-- Job Skills -->
        <h4 class="widget-title">{{__('Professional Skills')}}</h4>
        <div class="widget-content">
            <ul class="job-skills">
                @foreach($row->skills as $skill)
                    @php $trans = $skill->translateOrOrigin(app()->getLocale()); @endphp
                    <li><a target="_blank" href="{{ route('candidate.index', ['skill' => $skill->id]) }}">{{ $trans->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="sidebar-widget contact-widget">
    <h4 class="widget-title">{{__('Contact Us')}}</h4>
    <div class="widget-content">
        <!-- Comment Form -->
        <div class="default-form">
            <!--Comment Form-->
            <form method="post" action="{{ route("candidate.contact.store") }}"  class="bravo-contact-block-form">
                <input type="hidden" name="origin_id" value="{{$row->id}}">
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
