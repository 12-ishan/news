<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin\User;
use App\Models\Admin\Role;
use App\Models\Admin\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         $this->userId = Auth::user()->id;
    //        // $this->accountId = Auth::user()->accountId;
    //         return $next($request);
    //     });
    // }
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
    
            if ($user->roleId == 1) {
                $this->userId = $user->id;
                // $this->accountId = $user->accountId;
    
                return $next($request);
            }
    
            return response()->view('admin.permissionDenied', [], 403);
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

        $data["user"] = User::orderBy('sortOrder')->get();
      
        $data["pageTitle"] = 'Manage User';
        $data["activeMenu"] = 'user';
        return view('admin.user.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["role"] = Role::orderBy('id')->get();
        $data["parentUser"] = User::where('roleId','3')->orderBy('sortOrder')->get();

        $data["pageTitle"] = 'Add User';
        $data["activeMenu"] = 'user';
        return view('admin.user.create')->with($data);
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
           // 'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'name.required'=> 'Name is required',
            'role.required'=> 'role is required',
        ]);
    

        $user = new User();

        //Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $user->imageId, $this->userId, "uploads/user/"); //Image, ReferenceRecordId, UserId, Path
            
            $user->imageId = $mediaId;
 
         }

       // $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        // $user->meetingUsername = $request->input('meetingUsername');
        // $user->meetingPassword = $request->input('meetingPassword');

        $user->roleId = $request->input('role');
        $user->parentId = $request->input('parentId');
        $user->status = 1;
        $user->sortOrder = 1;

        $user->increment('sortOrder');

        $user->save();

        $user->roles()->sync($request->input('role'));

        return redirect()->route('user.index')->with('message', 'User Added Successfully');
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

        $data['user'] = User::find($id);
        $data["role"] = Role::orderBy('sortOrder')->get();
        $data['hasRole'] = $data['user']->roles->pluck('id')->toArray(); 
        // echo '<pre>';
        // print_r($data['hasRole']);
        // die();
      
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update User';
        $data["activeMenu"] = 'user';
        return view('admin.user.create')->with($data);
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
        // echo '<pre>';
        // print_r($request->all());
        // die();

        $this->validate(request(), [
           // 'username' => 'required',
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'name.required'=> 'Name is required',
            'role.required'=> 'role is required',
        ]);
        
        $id = $request->input('id');

        $user = User::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $user->imageId, $this->userId, "uploads/user/"); //Image, ReferenceRecordId, UserId, Path
            
            $user->imageId = $mediaId;
 
         }
        $user->name = $request->input('name');
       // $user->email = $request->input('email');

        // $user->meetingUsername = $request->input('meetingUsername');
        // $user->meetingPassword = $request->input('meetingPassword');

        if($request->filled('password')) {


        $user->password = Hash::make($request->input('password'));

        }

        $user->roleId = $request->input('role');
        $user->save();

        $user->roles()->sync($request->input('role'));
     

        return redirect()->route('user.index')->with('message', 'User Updated Successfully');
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
        $user = User::find($id);
        $user->delete($id);

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
                $user = User::find($id);
                $user->delete();
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
                $user = User::find($id);
                $user->sortOrder = $values->position;
                $result = $user->save();
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

        $user = User::find($id);
        $user->status = $status;
        $result = $user->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
