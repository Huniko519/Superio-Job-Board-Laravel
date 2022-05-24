<?php

    namespace Modules\Booking\Listeners;

    use App\Notifications\AdminChannelServices;
    use App\Notifications\PrivateChannelServices;
    use App\User;
    use Illuminate\Support\Facades\Auth;
    use Modules\Booking\Events\BookingCreatedEvent;
    use Modules\Booking\Events\SetPaidAmountEvent;

    class SetPaidAmountListen
    {
        public function handle(SetPaidAmountEvent $event)
        {
            $booking = $event->booking;
            $vendor = $booking->vendor()->where('status', 'publish')->first();

            $data = [
                'event'   => 'SetPaidAmountEvent',
                'to'      => 'admin',
                'id'      => $booking->id,
                'name'    => Auth::user()->display_name,
                'avatar'  => Auth::user()->avatar_url,
                'link'    => route('report.admin.booking'),
                'type'    => $booking->object_model,
                'message' => __(':name has updated the PAID amount on :title', ['name' => @$vendor->display_name, 'title' => $booking->service->title]),
            ];

            Auth::user()->notify(new AdminChannelServices($data));
            // notify vendor
            if ($vendor) {
                if (!$vendor->hasAnyPermission(['setting_manage'])) {
                    $data['to'] = 'vendor';
                    $data['link'] = route("vendor.bookingReport");
                    $data['message'] = __('Administrator has updated the PAID amount on :title', ['title' => $booking->service->title]);
                    $vendor->notify(new PrivateChannelServices($data));
                }
            }

            $customer = User::where('id', $booking->customer_id)->where('status', 'publish')->first();

            if ($customer) {
                if (!$customer->hasAnyPermission(['setting_manage'])) {
                    $data['to'] = 'customer';
                    $data['link'] = route('user.booking_history');
                    $customer->notify(new PrivateChannelServices($data));
                }
            }
        }
    }
