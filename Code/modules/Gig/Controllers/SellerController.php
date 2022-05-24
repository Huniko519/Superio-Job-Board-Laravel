<?php


namespace Modules\Gig\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Gig\Events\SellerDeliveryEvent;
use Modules\Gig\Models\Gig;
use Modules\Gig\Models\GigOrder;
use Modules\Gig\Models\GigOrderActivity;
use Modules\Media\Models\MediaFile;

class SellerController extends FrontendController
{

    public function orders(Request $request){
        $query = GigOrder::query()->where([
            'author_id'=>auth()->id()
        ])->whereHas('gig')->orderByDesc('id');

        if($s = $request->query('status')){
            $query->where('status',$s);
        }

        $data = [
            'page_title'=>__("Manage Orders"),
            'rows'=>$query->paginate(20)
        ];
        return view("Gig::frontend.seller.order.index",$data);
    }

    public function dashboard(Request $request){
        $this->checkPermission('gig_manage');

        $orders = GigOrder::query()->where([
            'author_id'=>auth()->id()
        ])->whereHas('gig')->orderByDesc('id');

        if($s = $request->query('status')){
            $orders->where('bc_gig_orders.status',$s);
        }

        $data = [
            'page_title'=>__('Seller Dashboard'),
            'rows'=>$orders->paginate(20),
            'auth'=>auth()->user(),
            'count_gig'=> Gig::where([
                'author_id'=>auth()->id()
            ])->count()
        ];
        return view("Gig::frontend.seller.dashboard.index",$data);
    }

    public function orderActivity(Request $request, $id){

        $order = GigOrder::query()->where('author_id', Auth::id())->find($id);
        if(empty($order)){
            abort(404);
        }

        $data = [
            'order' => $order,
            'tab' => 'activity',
            'page_title' => __("Order Activity"),
            'disable_header_shadow' => true
        ];
        return view("Gig::frontend.seller.order.detail",$data);
    }

    public function orderRequirements(Request $request, $id){
        $order = GigOrder::query()
            ->where('author_id', Auth::id())
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
        return view("Gig::frontend.seller.order.detail",$data);
    }

    public function sendMessage(Request $request){
        $order = GigOrder::query()->where('author_id', Auth::id())->find($request->post('order_id'));
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
                    if($type == 'delivered'){
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
        if($type == 'delivered'){
            $orderActivity = $order->addActivity(GigOrderActivity::TYPE_DELIVERED, $data);
            $order->last_delivered = date('Y-m-d H:i:s');
            $order->status = GigOrder::DELIVERED;
            $order->save();
            SellerDeliveryEvent::dispatch($orderActivity);
        }else{
            $orderActivity = $order->addActivity(GigOrderActivity::TYPE_NORMAL_MESSAGE, $data);
        }

        return back()->withFragment('#activity-'.$orderActivity->id);
    }
}
