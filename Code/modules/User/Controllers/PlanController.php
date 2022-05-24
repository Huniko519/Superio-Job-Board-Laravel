<?php


namespace Modules\User\Controllers;


use Illuminate\Http\Request;
use Modules\FrontendController;
use Modules\Order\Helpers\CartManager;
use Modules\User\Models\Plan;
use Modules\User\Models\Role;
use Modules\User\Models\UserPlan;

class PlanController extends FrontendController
{

    public function index(){

        if(auth()->check()){
            $role = auth()->user()->role;
        }else{
            $role = Role::find('employer');
        }
        $data = [
            'page_title'=>__('Pricing Packages'),
            'plans'=>$role->plans,
            'user'=>auth()->user(),
        ];
        return view("User::frontend.plan.index",$data);
    }

    public function myPlan(){

        if(!auth()->user()->user_plan){
            return redirect(route('plan'));
        }
        $data = [
            'page_title'=>__('My Plan'),
            'user'=>auth()->user(),
        ];
        return view("User::frontend.plan.my-plan",$data);
    }

    public function buy(Request $request,$id){
        $plan = Plan::find($id);
        if(!$plan) return;

        $user = auth()->user();

        $plan_page = route('plan');
        $my_plan = route('user.plan');

        if($user->role_id != $plan->role_id){
            return redirect()->to($plan_page)->with("warning",__("Please select other plan"));
        }

        $user_plan = $user->user_plan;
//        if($user_plan and $user_plan->plan_id == $plan->id and $user_plan->is_valid){
//            return redirect()->to($plan_page)->with("warning",__("Please select other plan"));
//        }

        if($request->query('annual') and !$plan->annual_price){
            return redirect()->to($plan_page)->with("warning",__("This plan doesn't have annual pricing"));
        }

        // For Annual price
        if($request->query('annual')){
            CartManager::clear();
            CartManager::add($plan,$plan->title,1,$plan->annual_price,['annual'=>1]);
            return redirect('checkout');
        }

        // For Normal Price
        if(!$plan->price || $plan->price == 0)
        {
            // For Free
            $new_user_plan = UserPlan::query()->find($user->id);
            if(empty($new_user_plan)){
                $new_user_plan = new UserPlan();
                $new_user_plan->id = $user->id;
            }
            $new_user_plan->plan_id = $id;
            $new_user_plan->price = $plan->price;
            $new_user_plan->start_date = date('Y-m-d H:i:s');
            $new_user_plan->end_date = date('Y-m-d H:i:s',strtotime('+ '.$plan->duration.' '.$plan->duration_type));
            $new_user_plan->max_service = $plan->max_service;
            $new_user_plan->plan_data = $plan;
            $new_user_plan->save();
            return redirect()->to($my_plan)->with('success', __("Purchased user package successfully"));
        }else{
            CartManager::clear();
            CartManager::add($plan);
            return redirect('checkout');
        }

    }
}
