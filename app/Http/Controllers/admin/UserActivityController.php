<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\NewsCategory;
use App\Models\Admin\NewsSubCategory;
use App\Models\Admin\News;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

//use App\Http\Requests\StorenewsRequest;


class UserActivityController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->accountId = Auth::user()->accountId;
            return $next($request);
        });
    }

    public function activity(){

        $activities = Activity::all();
      //  return view('admin.partials.offset')->with($activities);

        $response = array('status' => 1, 'response' => $activities);

        return response()->json($response);

    }

}