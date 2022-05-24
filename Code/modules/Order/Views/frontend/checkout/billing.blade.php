<div class="checkout-form" data-select2-id="6">
    <h3 class="title">{{__('Billing Details')}}</h3>
    <div class="default-form" data-select2-id="5">
        <div class="row">
            <!--Form Group-->
            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                <div class="field-label">{{__('First name')}} <span class="text-danger">*</span></div>
                <input type="text" name="first_name" value="{{old('first_name',$user->billing_first_name ? $user->billing_first_name : $user->first_name)}}" placeholder="">
            </div>

            <!--Form Group-->
            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                <div class="field-label">{{__('Last name')}} <span class="text-danger">*</span></div>
                <input type="text" name="last_name" value="{{old('last_name',$user->billing_last_name ? $user->billing_last_name : $user->last_name)}}" placeholder="">
            </div>
            <div class="col-sm-6 mb-4 form-group">
                <label class="form-label">
                    {{ __("Phone") }} <span class="text-danger">*</span>
                </label>
                <input type="email" placeholder="{{__("Your Phone")}}"  value="{{$user->phone ?? ''}}" name="phone">
            </div>
            <div class="col-sm-6 mb-4 form-group">
                <label class="form-label">
                    {{ __("Country") }}  <span class="text-danger">*</span>
                </label>
                <select name="country" >
                    <option value="">{{__('-- Select --')}}</option>
                    @foreach(get_country_lists() as $id=>$name)
                        <option @if(($user->country ?? '') == $id) selected @endif value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 mb-4 form-group">
                <label class="form-label">
                    {{ __("State/Province/Region") }}
                </label>
                <input type="text"  value="{{$user->state ?? ''}}" name="state" placeholder="{{__("State/Province/Region")}}">
            </div>
            <div class="col-sm-6 mb-4 form-group">
                <label class="form-label">
                    {{ __("City") }}
                </label>
                <input type="text"  value="{{$user->city ?? ''}}" name="city" placeholder="{{__("Your City")}}">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="field-label">{{ __("Street address") }} <span class="text-danger">*</span></div>
                <input type="text" value="{{$user->address ?? ''}}" name="address" placeholder="{{__('House number and street name')}}">
                <input type="text" value="{{$user->address2 ?? ''}}" name="address_line_2" placeholder="{{__('Apartment,suite,unit etc. (optional)')}}">
            </div>
            <div class="col-sm-6 mb-4 form-group">
                <label class="form-label">
                    {{ __("ZIP code/Postal code") }}  <span class="text-danger">*</span>
                </label>
                <input type="text"  value="{{$user->zip_code ?? ''}}" name="zip_code" placeholder="{{__("ZIP code/Postal code")}}">
            </div>
            <div class="w-100"></div>
        </div>
    </div>
</div>
