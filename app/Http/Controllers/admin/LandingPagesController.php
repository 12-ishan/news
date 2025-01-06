<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\LandingPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LandingPagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->accountId = Auth::user()->accountId;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.LANDING_PAGE_MANAGER'))) {
           
        $data = array();

        $data["landingPage"] = LandingPage::orderBy('sort_order')->get();

        $data["pageTitle"] = 'Manage Landing Pages';
        $data["activeMenu"] = 'Landing Page';
        return view('admin.landingPages.manage')->with($data);
        }
        else{
            return view('admin.permissionDenied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.CREATE_LANDING_PAGE')) ) {
        $data = array();

        $data["pageTitle"] = 'Add Landing Page';
        $data["activeMenu"] = 'Landing Page';
        return view('admin.landingPages.create')->with($data);
         }
         else{
             return view('admin.permissionDenied');
         }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.CREATE_LANDING_PAGE')) ) {
           
        $this->validate(request(), [
            'title' => 'required',
 
        ]);

        $landingPage = new LandingPage();

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $landingPage->imageId, $this->userId, "uploads/landingPages/"); //Image, ReferenceRecordId, UserId, Path
           
            $landingPage->imageId = $mediaId;
 
         }

        $landingPage->title = $request->input('title');
        $landingPage->slug = str::slug($request->input('slug'));
        $landingPage->description = $request->input('description');
       
        $landingPage->status = 1;
        $landingPage->sort_order = 1;

        $landingPage->increment('sort_order');

        $landingPage->save();

        return redirect()->route('landing-page.index')->with('message', 'Category Added Successfully');
        }
        else{
            return view('admin.permissionDenied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.EDIT_LANDING_PAGE')) ) {
        
        $data = array();

        $data['landingPage'] = LandingPage::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Landing Page';
        $data["activeMenu"] = 'Landing Page';
        return view('admin.landingPages.create')->with($data);
         }
         else{
            return view('admin.permissionDenied');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
  if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.EDIT_LANDING_PAGE')) ) {
           
        $this->validate(request(), [
            'title' => 'required',
           
        ]);
        
        $id = $request->input('id');

        $landingPage = LandingPage::find($id);

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $landingPage->imageId, $this->userId, "uploads/landingPages/"); //Image, ReferenceRecordId, UserId, Path
           
            $landingPage->imageId = $mediaId;
 
         }

        $landingPage->title = $request->input('title');
        $landingPage->slug = urlencode($request->input('slug'));
        $landingPage->description = $request->input('description');

        $landingPage->save();

        return redirect()->route('landing-page.index')->with('message', 'category Updated Successfully');
  }
  else{
    return view('admin.permissionDenied');
  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) ||  auth()->user()->hasPermission(config('constants.DELETE_LANDING_PAGE')) ) {
           

        $id = $request->id;
        $landingPage = LandingPage::find($id);
        $landingPage->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }
    else{
        return response()->json([
            'status' => 0,
            'message' => 'You are not allowed to delete news.'
        ], 403);
    
    }
    }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
    if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.DELETE_ALL_LANDING_PAGE')) ){              

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $landingPage = LandingPage::find($id);
                $landingPage->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }
    else{
        return response()->json([
            'status' => 0,
            'message' => 'You are not allowed to delete news.'
        ], 403);
    
    }
    }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSortorder(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_LANDING_PAGE_SORTORDER'))) {

        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $landingPage = LandingPage::find($id);
                $landingPage->sort_order = $values->position;
                $result = $landingPage->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }
    else{
        return response()->json([
            'status' => 0,
            'message' => 'You are not allowed to delete news.'
        ], 403);
    
    }
    }

    /**
     * Update Status resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
         if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_LANDING_PAGE_STATUS')) ) {
           

        $status = $request->status;
        $id = $request->id;

        $landingPage = LandingPage::find($id);
        $landingPage->status = $status;
        $result = $landingPage->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }
    else{
        return response()->json([
            'status' => 0,
            'message' => 'You are not allowed to delete news.'
        ], 403);
    
    }
    }

}
