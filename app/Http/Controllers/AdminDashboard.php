<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    //direct admin dashboard
    public function dashboard(){
        return view('admin.dashboard.home');
    }
}
