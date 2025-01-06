<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // public function home(){

    //     $activities = Activity::all();
    //     $data["pageTitle"] = 'Dashboard';
    //     $data["activeMenu"] = 'dashboard';
    //     return view('admin.dashboard')->with(['data' => $data, 'activities', $activities]);

    // }

    public function home()
{
    $activities = null; 
    
     if (isset(Auth::user()->roleId) && Auth::user()->roleId == 1) {
      $activities = Activity::orderBy('created_at', 'desc')->get();// Fetch all activities
     }
    $data = [
        "pageTitle" => 'Dashboard',
        "activeMenu" => 'dashboard'
    ];

    return view('admin.dashboard', compact('data', 'activities'));
}

    public function permissionDenied(){

        $data["pageTitle"] = 'Permission Denied';
        //$data["activeMenu"] = 'dashboard';
        return view('admin.permissionDenied')->with($data);

    }

}
