<?php
namespace Modules\Dashboard\Admin;

use App\BaseModel;
use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Booking\Models\Booking;
use Modules\Candidate\Models\Candidate;
use Modules\Company\Models\Company;
use Illuminate\Support\Facades\Auth;

class DashboardController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        if(!is_admin()){
            $this->middleware('verified');
        }
    }
    public function index()
    {
        $f = strtotime('monday this week');
        $module = (is_candidate()) ? Candidate::class : Company::class;
        $data = [
            'top_cards' => $module::getTopCardsReport(),
            'notifications' => $module::getNotifications(),
            'views_chart_data' => $module::getDashboardChartData($f, time())
        ];
        return view('Dashboard::index', $data);
    }

    public function reloadChart(Request $request)
    {
        $chart = $request->input('chart');
        $module = (is_candidate()) ? Candidate::class : Company::class;
        switch ($chart) {
            case "views":
                $from = $request->input('from');
                $to = $request->input('to');
                return $this->sendSuccess([
                    'data' => $module::getDashboardChartData(strtotime($from), strtotime($to))
                ]);
                break;
        }
    }
}
