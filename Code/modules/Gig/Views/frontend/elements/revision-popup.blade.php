
<div class="model bc-model modal-normal" id="bc-request-revision-popup">
    <div class="popup-wrapper">
        <div class="apply-job-form default-form">
            <div class="form-inner">
                <h3 class="form-title text-center">{{ __("Request A Revision") }}</h3>

                @if($order->revision == 0)
                    <p class="no-revision">{{ __("This order has no revisions.") }}</p>
                @elseif(!empty($order->revisions) && $order->revision <= count($order->revisions))
                    <p class="no-revision">{{ __("No revision left") }}</p>
                @else
                    <form class="send-message-form" action="{{ route('buyer.send_message') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="type" value="revision">
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
                @endif
            </div>
        </div>
    </div>
</div>
