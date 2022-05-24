<?php


namespace Modules\Gig\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Gig\Events\BuyerRevisionEvent;
use Modules\Gig\Events\GigOrderCompletedEvent;
use Modules\Gig\Models\GigOrder;
use Modules\Gig\Models\GigOrderActivity;
use Modules\Media\Models\MediaFile;

class BuyerController extends FrontendController
{

    public function orders(Request $request){
        $query = GigOrder::query()->where([
            'customer_id'=>auth()->id()
        ])->orderByDesc('id');

        if($s = $request->query('status')){
            $query->where('status',$s);
        }

        $data = [
            'page_title'=>__("Manage Orders"),
            'rows'=>$query->paginate(20)
        ];
        return view("Gig::frontend.buyer.order.index",$data);
    }

    public function orderActivity(Request $request, $id){

        $order = GigOrder::query()->where('customer_id', Auth::id())->find($id);
        if(empty($order)){
            abort(404);
        }

        $data = [
            'order' => $order,
            'tab' => 'activity',
            'page_title' => __("Order Activity"),
            'disable_header_shadow' => true
        ];
        return view("Gig::frontend.buyer.order.detail",$data);
    }

    public function orderResolution(Request $request, $id){

        $order = GigOrder::query()->where('customer_id', Auth::id())->find($id);
        if(empty($order) || $order->status == 'completed' || $order->status == 'cancelled'){
            abort(404);
        }

        $data = [
            'order' => $order,
            'tab' => 'resolution',
            'page_title' => __("Resolution Center"),
            'disable_header_shadow' => true
        ];
        return view("Gig::frontend.buyer.order.detail",$data);
    }

    public function orderDelivery(Request $request, $id){
        $order = GigOrder::query()
            ->where('customer_id', Auth::id())
            ->find($id);
        if(empty($order)){
            abort(404);
        }

        $data = [
            'order' => $order,
            'tab' => 'delivery',
            'page_title' => __("Order Delivery"),
            'disable_header_shadow' => true
        ];
        return view("Gig::frontend.buyer.order.detail",$data);
    }

    public function orderRequirements(Request $request, $id){
        $order = GigOrder::query()
            ->where('customer_id', Auth::id())
            ->find($id);
        if(empty($order)){
            abort(404);
        }

        $data = [
            'order' => $order,
            'tab' => 'requirements',
            'page_title' => __("Requirements"),
            'disable_header_shadow' => true
        ];
        return view("Gig::frontend.buyer.order.detail",$data);
    }


    public function sendMessage(Request $request){
        $order = GigOrder::query()->where('customer_id', Auth::id())->find($request->post('order_id'));
        if(!$order){
            return back()->with('error', __("Order does not exist"));
        }
        if(empty($request->input('content'))){
            return back()->with('error', __("Message is a required field"));
        }
        $type = $request->input('type');
        $data = [
            'content' => $request->input('content'),
        ];
        if($files = $request->file('files')) {
            $file_id = [];
            if(count($files) > 4){
                return back()->with('danger',__("Maximum 4 files only"));
            }
            foreach ($files as $file){
                try {
                    if($type == 'revision') {
                        $file_id[] = MediaFile::saveUploadFile($file, 'order_attachment');
                    }else{
                        $file_id[] = MediaFile::saveUploadFile($file);
                    }
                }catch (\Exception $exception){
                    return back()->with('danger',$exception->getMessage());
                }
            }
            if(!empty($file_id)) {
                $data['file_ids'] = implode(',',$file_id);
            }

        }
        if($type == 'revision'){
            $orderActivity = $order->addActivity(GigOrderActivity::TYPE_REVISION, $data);
            $order->status = GigOrder::IN_REVISION;
            $order->save();
            BuyerRevisionEvent::dispatch($orderActivity);
        }else{
            $orderActivity = $order->addActivity(GigOrderActivity::TYPE_NORMAL_MESSAGE, $data);
        }

        return back()->withFragment('#activity-'.$orderActivity->id);
    }

    public function submitRequirements(Request $request){
        $order = GigOrder::query()->where('customer_id', Auth::id())->find($request->post('order_id'));
        if(!$order){
            return back()->with('error', __("Order does not exist"));
        }
        $order->requirements = $request->input('requirements');
        $order->start_date = date('Y-m-d H:i:s');
        $delivery_date = date('Y-m-d H:i:s', strtotime('+'.($order->delivery_time ?? 1).' days'));
        $order->delivery_date = $delivery_date;
        $order->status = GigOrder::IN_PROGRESS;
        $order->save();
        $order->addActivity(GigOrderActivity::TYPE_REQUIREMENTS);
        $order->addActivity(GigOrderActivity::TYPE_ORDER_STARTED);
        $order->addActivity(GigOrderActivity::TYPE_DELIVERY_DATE);
        return back();
    }

    public function acceptOrder(Request $request, $id){
        $order = GigOrder::query()->where('customer_id', Auth::id())->find($id);
        if(!$order){
            return back()->with('error', __("Order does not exist"));
        }
        $order->addActivity(GigOrderActivity::TYPE_ORDER_COMPLETED, []);
        $order->status = GigOrder::COMPLETED;
        $order->save();

        GigOrderCompletedEvent::dispatch($order);
        return back();
    }

}
