<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = CarbonPeriod::create(Carbon::today()->subDays(7), '1 Day', Carbon::today());

        $users = [];
        foreach ($period as $dt) {
            $users[$dt->format("M d")] = User::whereDate('created_at', '=', $dt->format('Y-m-d'))->count();
        }

        $date = Carbon::now()->format('Y-m-d');
        $pre_now = Carbon::now()->subMinutes(5);
        $time = Carbon::now()->format('Y-m-d-H-i-s');
        $pre_now = Carbon::now()->subMinutes(5);
        //  dd($date);
        $expired_orders=Order::select('orders.id','orders.created_at','vendors.name as vendor','vendors.logo',DB::raw("TIMESTAMPDIFF(MINUTE,orders.created_at,'$time') as duration"))
        ->join('vendors','vendors.id','orders.vendor_id')
        ->having('duration','>',5)
        ->where('orders.status','ordered')
            ->orderBy('orders.id', 'DESC')->limit(6)->get();

        $orderPlacedCount = Order::whereDate('created_at', $date)->count();
        $orderConfirmedCount = Order::whereDate('created_at', $date)->where('status', 'placed')->count();
        $orderInTransistCount = Order::whereDate('created_at', $date)->where('status', 'picked')->count();
        $orderDeliveredCount = Order::whereDate('created_at', $date)->where('status', 'delivered')->count();
        $orderCancelledCount = Order::whereDate('created_at', $date)->where('status', 'cancelled')->count();
        $orderReplaceCount = Order::whereDate('created_at', $date)->where('status', 'replace')->count();

        $data=[
            'orderPlacedCount'=>$orderPlacedCount,
            'orderConfirmedCount'=>$orderConfirmedCount,
            'orderInTransistCount'=>$orderInTransistCount,
            'orderDeliveredCount' => $orderDeliveredCount,
            'orderCancelledCount' => $orderCancelledCount,
            'orderReplaceCount'=>$orderReplaceCount

        ];


        return view('backend/dashboard/index',$data, compact('users', 'date', 'expired_orders'));
    }

    public function subscribePushNotification(Request $request)
    {
        $token = $request->token ?? false;

        if ($token) {
            return subscribePushNotification($token);
        }

        return false;
    }

    public function connect(Request $request)
    {
        return view('backend/help/connect');
    }

    public function getAjaxOrderCounts(Request $request)
    {
        $selectedDate = $request->input('date');
        $period = CarbonPeriod::create(Carbon::create($selectedDate)->subDays(7), '1 Day', Carbon::create($selectedDate));
        $users = [];
        foreach ($period as $dt) {
            $users[$dt->format("M d")] = User::whereDate('created_at', '=', $dt->format('Y-m-d'))->count();
            $formattedDate = $dt->format("M d");
            $userCount = User::whereDate('created_at', $dt)->count();
            $users[$formattedDate] = $userCount;
        }
        $seriesData = array_values($users);
        $categories = array_keys($users);



        // Retrieve the order counts for the selected date
        $orderPlacedCount = Order::whereDate('created_at', $selectedDate)->count();
        $orderConfirmedCount = Order::whereDate('created_at', $selectedDate)->where('status', 'placed')->count();
        $orderInTransistCount = Order::whereDate('created_at', $selectedDate)->where('status', 'picked')->count();
        $orderDeliveredCount = Order::whereDate('created_at', $selectedDate)->where('status', 'delivered')->count();
        $orderCancelledCount = Order::whereDate('created_at', $selectedDate)->where('status', 'cancelled')->count();
        $orderReplaceCount = Order::whereDate('created_at', $selectedDate)->where('status', 'replace')->count();



        // Return the order counts as a JSON response
        return response()->json([
            'seriesData' => $seriesData,
            'categories' => $categories,
            'orderPlacedCount'=>$orderPlacedCount,
            'orderConfirmedCount'=>$orderConfirmedCount,
            'orderInTransistCount'=>$orderInTransistCount,
            'orderDeliveredCount' => $orderDeliveredCount,
            'orderCancelledCount' => $orderCancelledCount,
            'orderReplaceCount'=>$orderReplaceCount
        ]);
    }

}
