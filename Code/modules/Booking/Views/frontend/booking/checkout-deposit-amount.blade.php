@if(auth()->check() && $booking->status == 'draft' && empty(setting_item('wallet_module_disable')))
    <hr/>
    <div class="form-group-item">
        <h5 class="form-section-title font-size-17 font-weight-bold">{{__("Credit want to pay?")}}</h5>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text border-width-1">{{__('Credit')}} {{ !empty(auth()->user()) ? auth()->user()->balance : 0  }}</span>
            </div>
            <input type="number" class="form-control deposit_amount border-width-1" value="0" name="credit">
            <div class="input-group-append">
                <span class="input-group-text convert_deposit_amount border-width-1">{{format_money(0)}}</span>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <h5 class="form-section-title font-size-17 font-weight-bold">{{__("Pay now")}}:</h5>
            <div class="val convert_pay_now">{{format_money(floatval($booking->deposit == null ? $booking->total : $booking->deposit))}}</div>
        </div>
    </div>
@endif
