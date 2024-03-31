<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use App\Models\User;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        $title = 'Trang chủ';
        // lấy user
        $users = User::where('role', 0)->orderBy('userID', 'DESC')->take(5)->get();
        // lấy order
        $orders = OrderModel::where('order_status', 'PENDING')->orderBy('orderID', 'DESC')->take(5)->get();
        
        $orderUserDetails = [];
        foreach ($orders as $order) {
        $user_id = $order->user_id;
        $userID = $users->firstWhere('userID', $user_id);
        if ($userID) {
            $orderUserDetails[$order->id] = $userID;
            }
        }

        // lấy product còn tồn
        $products = Product::join('variant', 'product.productID', '=', 'variant.product_id')
                        ->where('variant.stock_quantity', '>', 0)
                        ->distinct()
                        ->get(['product.*'])
                        ->count();
        // lấy product trong 24h
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $sub24h = Carbon::now('Asia/Ho_Chi_Minh')->subHours(24);
        $product24h = Product::where('created_at', '>=', $sub24h)->count();


        return view("admin.home.index", compact("title", "users", "orders","orderUserDetails","products","product24h"));
    } 


    public function dates(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = OrderModel::whereBetween('order_date', [$from_date, $to_date])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();
        foreach($get as $key => $val){
            $chart_date[] = array(
                'order_date' => $val->order_date,
                'total' => $val->total_ammount,
                'order' => $val->shipment_status
            );
        }
        echo $data = json_encode($chart_date); 
    }

    public function filter_date(Request $request){
        $data = $request->all();

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        if($data['filter_date']=='7ngay'){
            $get = OrderModel::whereBetween('order_date', [$sub7days, $now])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();
        } elseif ($data['filter_date']=='thangtruoc'){
            $get = OrderModel::whereBetween('order_date', [$dau_thangtruoc, $cuoi_thangtruoc])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();
        } elseif ($data['filter_date']=='thangnay'){
            $get = OrderModel::whereBetween('order_date', [$dauthangnay, $now])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();
        } else {
            $get = OrderModel::whereBetween('order_date', [$sub365days, $now])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();
        }

        foreach($get as $key => $val){
            $chart_date[] = array(
                'order_date' => $val->order_date,
                'total' => $val->total_ammount,
                'order' => $val->shipment_status
            );
        }
        echo $data = json_encode($chart_date); 
    }

    public function chart30day(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = OrderModel::whereBetween('order_date', [$sub30days, $now])->where('order_status', 'PAID')->orderBy('order_date', 'ASC')->get();

        foreach($get as $key => $val){
            $chart_date[] = array(
                'order_date' => $val->order_date,
                'total' => $val->total_ammount,
                'order' => $val->shipment_status
            );
        }
        echo $data = json_encode($chart_date);

    }
}
