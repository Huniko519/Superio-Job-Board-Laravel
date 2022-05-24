<div class="model bc-model modal-normal" id="bc-delivery-popup">
    <div class="popup-wrapper">
        <div class="apply-job-form default-form">
            <div class="form-inner">
                <h3 class="form-title text-center">{{ __("Deliver Your Order Now") }}</h3>

                <form class="send-message-form" action="{{ route('seller.send_message') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="type" value="delivered">
                    <div class="form-group">
                        <label id="message">{{ __("Message") }}</label>
                        <textarea id="message" required class="form-control" name="content" rows="5" placeholder="{{ __("Type your message here...") }}"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="attach-file">
                            <label> {{ __("Attach File (optional)") }} </label>
                            <input type="file" name="files[]" accept=".zip,image/*" multiple class="form-control-file">
                        </div>
                        <p><i>{{__("Maximum 4 files, (image or .zip)")}}</i></p>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="theme-btn btn-style-one bg-blue">{{ __("Send") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
