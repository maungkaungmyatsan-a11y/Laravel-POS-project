<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class AdminDashboard extends Controller
{
    //direct admin dashboard
    public function dashboard(){
        $userCount = User::where('role','user')->count();
        $adminCount = User::whereIn('role',['admin','superadmin'])->count();
        $orderCount = Order::whereIn('status',['pending','success'])->count();
        $rejectCount = Order::whereIn('status',['reject'])->count();
        $totalTransationAmount = PaymentHistory::sum('total_amount');
        $totalOrderSuccessAmount = Order::where('status','success')->sum('total_price');
        $messageCount = Contact::count();

        return view('admin.dashboard.home',compact('userCount','adminCount','orderCount','rejectCount','totalTransationAmount','totalOrderSuccessAmount','messageCount'));
    }
}
