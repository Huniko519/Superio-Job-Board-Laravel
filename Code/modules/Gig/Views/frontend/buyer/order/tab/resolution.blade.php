{{--Resolution center--}}
<div class="bc-order-panel">
    <form class="bc-order-cancel" method="POST" action="">
        @csrf
        <h2 class="text-center form-title">{{ __("Order Cancellation Request") }}</h2>
        <div class="form-group">
            <label id="message">{{ __("Message") }}</label>
            <textarea id="message" class="form-control" name="message" rows="5" placeholder="{{ __("Please be as detailed as possible...") }}"></textarea>
        </div>
        <div class="form-group">
            <label id="reason">{{ __("Cancellation Request Reason") }}</label>
            <select class="chosen-select" name="reason" id="reason">
                <option class="hidden" value="">{{ __("Select Cancellation Reason") }} </option>
                @foreach(cancellation_reason() as $key => $val)
                    <option value="{{ $key }}">{{ $val }} </option>
                @endforeach
            </select>
        </div>
        <div class="text-center mt-md-5 mt-4">
            <button type="submit" class="theme-btn btn-style-one bg-blue">{{ __("Submit Cancellation Request") }}</button>
        </div>
    </form>
</div>
