<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //order list
    public function orderList($state = '')
    {

        $orderList = Order::select('orders.id as order_id', 'orders.count as order_count', 'users.name as user_name', 'orders.order_code', 'orders.status', 'orders.created_at')
                            ->leftJoin('users', 'orders.user_id', 'users.id')
                            ->when(request('orderCode'), function ($query) {
                                $query->where('orders.order_code', 'like', '%' . request('orderCode') . '%');
                            });

        if ($state == 'reject') {
            $orderList = $orderList->where('orders.status', '=', 'reject');
        } else {
            $orderList = $orderList->where('orders.status', '!=', 'reject');
        }

        $orderList = $orderList->groupBy('orders.order_code')
                               ->orderBy('orders.created_at', 'desc')
                               ->get();

        foreach ($orderList as $item) {
            $orderData = Order::select('products.name', 'products.price', 'products.image', 'orders.count as order_count', 'products.stock as current_stock', 'orders.order_code', 'orders.created_at', 'orders.total_price')
                            ->leftJoin('products', 'orders.product_id', 'products.id')
                            ->where('orders.order_code', $item->order_code)
                            ->get();

            $eachOrderStatus = true;
            foreach ($orderData as $eachItem) {
                if ($eachItem->order_count > $eachItem->current_stock) {
                    $eachOrderStatus = false;
                    break;
                }
            }

            $item['confirmStatus'] = $eachOrderStatus;
        }

        return view('admin.order.list', compact('orderList'));
    }

    //order details
    public function orderDetails($orderCode)
    {
        $orderData = Order::select('products.id as product_id', 'products.name', 'products.price', 'products.image', 'orders.count as order_count', 'products.stock as current_stock', 'users.name', 'users.phone', 'users.address', 'orders.status', 'orders.order_code', 'orders.created_at', 'orders.total_price')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->where('orders.order_code', $orderCode)
            ->get();

        $paymentHistories = PaymentHistory::select('payments.account_type as payments_method', 'payment_histories.created_at', 'payment_histories.phone', 'payment_histories.total_amount', 'payment_histories.address', 'payment_histories.payslip_image')
            ->leftJoin('payments', 'payment_histories.payment_method', 'payments.id')
            ->where('order_code', $orderCode)
            ->first();

        $totalAmt = 5000;
        foreach ($orderData as $item) {

            $totalAmt += $item['total_price'];

        }

        return view('admin.order.details', compact('orderData', 'totalAmt', 'paymentHistories'));

    }

    //Reject
    public function orderReject(Request $request)
    {
        Order::where('order_code', $request['orderCode'])->update([
            'status' => 'reject',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'order cancel',
        ]);
    }

    //accept order
    public function orderAccept(Request $request)
    {
        Order::where('order_code', $request['orderCode'])->update([
            'status' => 'success',
        ]);

        //reduce stock
        foreach ($request['data'] as $item) {
            Product::where('id', $item['productId'])->decrement('stock', $item['orderCount']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'order confirm',
        ]);
    }

    //order accept from order list
    public function orderListAccept(Request $request)
    {
        //change status according to user action
        Order::where('order_code', $request['orderCode'])->update([
            'status' => $request['status'],
        ]);

        //order reduce
        if ($request['status'] == 'success') {
            $orderProducts = Order::select('product_id', 'count')->where('order_code', $request['orderCode'])->get();

            foreach ($orderProducts as $item) {
                Product::where('id', $item['product_id'])->decrement('stock', $item['count']);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'order confirm',
        ]);
    }
}
