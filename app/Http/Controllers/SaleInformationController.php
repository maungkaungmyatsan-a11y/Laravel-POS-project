<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SaleInformationController extends Controller
{
    //
    public function saleInformation()
    {
        $orders = Order::where('status', 'success')
                        ->when(request('orderCode'), function ($query) {
                            $query->where('order_code', 'like', '%' . request('orderCode') . '%');
                        })
                        ->get();

        $total = 0;
        foreach ($orders as $item) {
            $total += $item['total_price'];
        }
        return view('admin.sale.information', compact('orders', 'total'));
    }
}
