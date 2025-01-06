<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\WebsiteLogo;


class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisation_id = Auth::user()->organisation_id;    
            return $next($request);
        });
    }

    public function index()
    {
         if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_HOME_PAGE_SETTING')) || auth()->user()->hasPermission(config('constants.UPDATE_WEBSITE_LOGO'))) {
        $generalSettings = GeneralSettings::where('id', 1)->first();
       
        $data = [
            'generalSettings' => $generalSettings,
            
        ];
        $data["pageTitle"] = 'Home Page Settings';
        $data["activeMenu"] = 'generalSettings';
        return view('admin.generalSettings.home')->with($data);
         }
         else{
              return view('admin.permissionDenied');
         }
    }
      

public function update(Request $request)
{
   if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_HOME_PAGE_SETTING')) || auth()->user()->hasPermission(config('constants.UPDATE_WEBSITE_LOGO'))) {
           
        
    $GeneralSettings = GeneralSettings::where('id', 1)->first();
    
   if ($request->hasFile('image')) { 
        $mediaId = imageUpload($request->image, $GeneralSettings->imageId ?? null, $this->userId, "uploads/home/");
        
        $GeneralSettings->imageId = $mediaId;
    }

    $GeneralSettings->meta_title = $request->input('metaTitle');
    $GeneralSettings->meta_description = $request->input('metaDescription');
    $GeneralSettings->button_url = $request->input('buttonUrl');
    $GeneralSettings->description = $request->input('description');
    $GeneralSettings->save();
    $request->session()->flash('message', 'Contact Updated Successfully');
    return redirect()->route('home');
}
else{
    return view('admin.permissionDenied');
}
}

public function websiteLogo()
{
    if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_HOME_PAGE_SETTING')) || auth()->user()->hasPermission(config('constants.UPDATE_WEBSITE_LOGO'))) {
        $websiteLogo = WebsiteLogo::with(['favicon', 'image'])->where('id', 1)->first();
        // echo '<pre>';
        // print_r($websiteLogo->favicon->name);
        // die();
   
    $data = [
        'websiteLogo' => $websiteLogo,
        
    ];
    $data["pageTitle"] = 'website logo Setting';
    $data["activeMenu"] = 'generalSettings';
    return view('admin.generalSettings.websiteLogo')->with($data);
    }
    else{
         return view('admin.permissionDenied');
    }
}
  
public function updateLogo(Request $request)
{
  
    if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_HOME_PAGE_SETTING')) || auth()->user()->hasPermission(config('constants.UPDATE_WEBSITE_LOGO'))) {
          
   
    $websiteLogo = WebsiteLogo::where('id', 1)->first();

    if ($request->hasFile('favicon')) { 
        $mediaId = imageUpload($request->favicon, $websiteLogo->favicon ?? null, $this->userId, "uploads/favicon/");
     
        $websiteLogo->favicon = $mediaId;
    }
  
    
   if ($request->hasFile('image')) { 
        $mediaId = imageUpload($request->image, $websiteLogo->imageId ?? null, $this->userId, "uploads/home/");
      
        $websiteLogo->imageId = $mediaId;
    }

  

    $websiteLogo->page_title = $request->input('title');
    $websiteLogo->save();
    $request->session()->flash('message', 'Contact Updated Successfully');
    return redirect()->route('websiteLogo');
}
else{
    return view('admin.permissionDenied');
}
}

}