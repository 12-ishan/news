<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\MediaCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MediaCategoryController extends Controller
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
        $data = array();
        $data['mediaCategory'] = MediaCategory::orderBy('sort_order')->get();

        $data["pageTitle"] = 'Manage Media Category';
        $data["activeMenu"] = 'Media Category';
        return view('admin.mediaCategory.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
       
        $data["pageTitle"] = 'Add Media Category';
        $data["activeMenu"] = 'Media Category';
        return view('admin.mediaCategory.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
 
        ]);

        $mediaCategory = new MediaCategory();

        
        $mediaCategory->name = $request->input('name');
        $mediaCategory->slug = str::slug($request->input('name'));
       // $mediaCategory->description = $request->input('description');
       
        $mediaCategory->status = 1;
        $mediaCategory->sort_order = 1;

        $mediaCategory->increment('sort_order');

        $mediaCategory->save();

        return redirect()->route('media-category.index')->with('message', 'Category Added Successfully');
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
        
        $data = array();

        $data['mediaCategory'] = MediaCategory::find($id);
      
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Media Category';
        $data["activeMenu"] = 'Media Category';
        return view('admin.mediaCategory.create')->with($data);
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

        $this->validate(request(), [
            'name' => 'required',
           
        ]);
        
        $id = $request->input('id');

        $mediaCategory = MediaCategory::find($id);

        $mediaCategory->name = $request->input('name');
        $mediaCategory->slug = urlencode($request->input('name'));
       // $mediaCategory->description = $request->input('description');

        $mediaCategory->save();

        return redirect()->route('media-category.index')->with('message', 'category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $mediaCategory = MediaCategory::find($id);
        $mediaCategory->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $mediaCategory = MediaCategory::find($id);
                $mediaCategory->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $mediaCategory = MediaCategory::find($id);
                $mediaCategory->sort_order = $values->position;
                $result = $mediaCategory->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }

    /**
     * Update Status resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $mediaCategory = MediaCategory::find($id);
        $mediaCategory->status = $status;
        $result = $mediaCategory->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
