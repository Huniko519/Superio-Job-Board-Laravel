<div class="form-checkout" id="form-checkout">
    <input type="hidden" name="code" value="{{$booking->code}}">
    <div class="mb-5 shadow-soft bg-white rounded-sm">
        <div class="pt-4 pb-5 px-5">
            <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">
                {{ __("Let us know who you are") }}
            </h5>
            <div class="row">
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("First Name") }}
                    </label>
                    <input type="text" placeholder="{{__("First Name")}}" class="form-control" value="{{$user->first_name ?? ''}}" name="first_name">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("Last name") }}
                    </label>
                    <input type="text" placeholder="{{__("Last Name")}}" class="form-control" value="{{$user->last_name ?? ''}}" name="last_name">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("Email") }}
                    </label>
                    <input type="email" placeholder="{{__("email@domain.com")}}" class="form-control" value="{{$user->email ?? ''}}" name="email">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("Phone") }}
                    </label>
                    <input type="email" placeholder="{{__("Your Phone")}}" class="form-control" value="{{$user->phone ?? ''}}" name="phone">
                </div>
                <div class="w-100"></div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("Address line 1") }}
                    </label>
                    <input type="text" placeholder="{{__("Address line 1")}}" class="form-control" value="{{$user->address ?? ''}}" name="address_line_1">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("Address line 2") }}
                    </label>
                    <input type="text" placeholder="{{__("Address line 2")}}" class="form-control" value="{{$user->address2 ?? ''}}" name="address_line_2">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("State/Province/Region") }}
                    </label>
                    <input type="text" class="form-control" value="{{$user->state ?? ''}}" name="state" placeholder="{{__("State/Province/Region")}}">
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("ZIP code/Postal code") }}
                    </label>
                    <input type="text" class="form-control" value="{{$user->zip_code ?? ''}}" name="zip_code" placeholder="{{__("ZIP code/Postal code")}}">
                </div>
                <div class="col-sm-6 mb-4">

                    <label class="form-label">
                        {{ __("Country") }}
                    </label>
                    <select name="country" class="form-control">
                        <option value="">{{__('-- Select --')}}</option>
                        @foreach(get_country_lists() as $id=>$name)
                            <option @if(($user->country ?? '') == $id) selected @endif value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-4">
                    <label class="form-label">
                        {{ __("City") }}
                    </label>
                    <input type="text" class="form-control" value="{{$user->city ?? ''}}" name="city" placeholder="{{__("Your City")}}">
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <div class="mb-6">
                        <label class="form-label">
                            {{ __("Special Requirements") }}
                        </label>
                        <div class="input-group">
                            <textarea name="customer_notes" cols="30" rows="6" class="form-control" placeholder="{{__('Special Requirements')}}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col-sm-12 mb-4">
                    @include ('Booking::frontend/booking/checkout-deposit')
                    @include ($service->checkout_form_payment_file ?? 'Booking::frontend/booking/checkout-payment')
                </div>
                <div class="col-sm-12 mb-4">
                    @php
                        $term_conditions = setting_item('booking_term_conditions');
                    @endphp
                    <div class="mb-3">
                        <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                            <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="term_conditions">
                            <label class="custom-control-label" for="termsCheckbox">
                                <small>
                                    {{__('By continuing, you agree to the')}}
                                    <a target="_blank" class="link-muted" href="{{get_page_url($term_conditions)}}">{{__('Terms and Conditions')}}</a>
                                </small>
                            </label>
                        </div>
                        @if(setting_item("booking_enable_recaptcha"))
                            <div class="form-group">
                                {{recaptcha_field('booking')}}
                            </div>
                        @endif
                    </div>
                    <div class="html_before_actions"></div>
                    <p class="alert-text mt10" v-show=" message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></p>
                    <button class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3" @click="doCheckout">{{__('CONFIRM BOOKING')}}
                        <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
