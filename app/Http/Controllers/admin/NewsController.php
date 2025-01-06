<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\NewsCategory;
use App\Models\Admin\MediaCategory;
use App\Models\Admin\News;
use App\Models\Admin\Media;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Gate;

//use App\Http\Requests\StorenewsRequest;


class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
           // $this->accountId = Auth::user()->accountId;
        //     $currentRoute = $request->route()->getName(); 
        // $currentUrl = $request->fullUrl(); 

        // activity('news')->event(config('event.EVENT_UPDATED'))
        //     ->causedBy(auth()->user())
        //     ->withProperties([
        //         'route' => $currentRoute,
        //         'url' => $currentUrl,
        //     ])
        //     ->log("Accessed the '{$currentRoute}' page");

        return $next($request);
        });
    }



    public function getMediaByCategory($categoryId)
    {
        $medias = Media::where('category_id', $categoryId)->get();
        // echo '<pre>';
        // print_r($medias);
        // die();
    
        $html = '';
        foreach ($medias as $media) {

            $html .= '<label style="display: inline-block; margin: 10px; cursor: pointer;">'
            
            . '<button type="button" class="close delete-image" aria-label="Close" data-media-id="' . $media->id . '">'
            . '<span aria-hidden="true">&times;</span>'
            . '</button>'
                   . '<input type="radio" name="media" value="' . $media->id . '" style="margin-right: 5px;" />'
                   . '<img width="100" height="60" src="'. url('/uploads/media/' . $media->name) .'" alt="image">'
                 
                   . '</label>';
        }
    
        return response()->json(['html' => $html]);
    }
    
    
    
    


    private function getMediaCategory() {
        $mediaCategories = MediaCategory::orderBy('sort_order')->get();
    
        $html = '';
        foreach ($mediaCategories as $mediaCategory) {
          
            $html .= '<a href="javascript:void(0);" class="category-link" data-category-id="' . $mediaCategory->id . '">'
                   . $mediaCategory->name . '</a><br>';
        }
    
        return $html;
    }
    
    
    public function previewSelectedMedia(Request $request)
{
    $mediaId = $request->input('media_id');
    $media = Media::find($mediaId);

    if (!$media) {
        return response()->json(['error' => 'Media not found'], 404);
    }

    $imageUrl = $media->name;

    return response()->json(['image_url' => $imageUrl,
                              'media_id' => $mediaId ]);
}


  
    public function index()
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.NEWS_MANAGER')) ) {

            $data = array();
        $data["news"] = News::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage News';
        $data["activeMenu"] = 'news';

        return view('admin.news.manage')->with($data);
        }
     
        else{
            return view('admin.permissionDenied');
        }
    }

    
    public function create()
    {
       if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.CREATE_NEWS')) ) {

            $data = array();
            $data['mediaCategory'] = $this->getMediaCategory();

            $data["newsCategory"] = NewsCategory::where('status',1)->orderBy('sortOrder')->get();
           
            $data["pageTitle"] = 'Add News';
            $data["activeMenu"] = 'News';

            // activity('news')
            // ->causedBy(auth()->user())
            // ->log('Viewed news create page');

            return view('admin.news.create')->with($data);

           
        }
        else{
            return view('admin.permissionDenied');
        }

       
    }

    public function store(Request $request)
    { 
        // echo '<pre>';
        // print_r($request->all());
        // die();
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.CREATE_NEWS')) ) {
           // abort(403, 'You do not have permission to add news.');
        
           $this->validate(request(), [
            'title' => 'required',
            'categoryId' => 'required',
           // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

         $news = new News();


         $browseImage = $request->input('mediaId');
        //  echo '<pre>';
        //  print_r($browseImage);
        //  die();
        if ($browseImage) {
            $news->imageId = $browseImage;
            // echo '<pre>';
            // print_r($news->imageId);
            // die();
         }
        
        else if($request->hasFile('image')) { 

            $mediaId = imageUpload($request->image, $news->imageId, $this->userId, "/uploads/newsImage/"); 
            $news->imageId = $mediaId;
         }
    
        $news->category_id = $request->input('categoryId');
        $news->parent_id = $request->input('parentId');
        $news->title = $request->input('title');
        $news->meta_description = $request->input('metaDescription');
        $news->slug = Str::slug($request->input('title'));
        $news->description = $request->input('description');
        $news->status = 1;
        $news->sortOrder = 1;
        $news->increment('sortOrder');
        $news->save();
    
        return redirect()->route('news.index')->with('message', 'news Added/Updated Successfully');

        }else{
            return view('admin.permissionDenied');
        }

      
    }
    
    
    public function edit($id)
    { 
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1)  || auth()->user()->hasPermission(config('constants.EDIT_NEWS') )) {
        $data = array();
        $data['mediaCategory'] = $this->getMediaCategory();
        $data["news"] = News::find($id);
        // echo '<pre>';
        // print_r($data['news']);
        // die();
        $data["newsCategory"] = NewsCategory::orderBy('sortOrder')->get();
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update News';
        $data["activeMenu"] = 'news';
       
    //    echo '<pre>';
    //    print_r( $data["news"]->imageId );
    //    die();
        
        return view('admin.news.create')->with($data);
        }
        else{

            return view('admin.permissionDenied');
        }

    }
    

    public function update(Request $request, $id)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.EDIT_NEWS') )) {

        $news = News::find($id);


        $browseImage = $request->input('mediaId');
        if ($browseImage) {
            $news->imageId = $browseImage;
            // echo '<pre>';
            // print_r($news->imageId);
            // die();
         }
    
        else if ($request->hasFile('image')) {
            $mediaId = imageUpload($request->image, $news->imageId, $this->userId, "uploads/newsImage/");
            $news->imageId = $mediaId;
        }
    
        $news->category_id = $request->input('categoryId');
        $news->parent_id = $request->input('parentId');
        $news->title = $request->input('title');
        $news->meta_description = $request->input('metaDescription');
        $news->slug = Str::slug($request->input('title'));
        $news->description = $request->input('description');
        $news->status = 1;
        $news->save();
    
        return redirect()->route('news.index')->with('message', 'news Updated Successfully');
    }
    else{
        return view('admin.permissionDenied');
    }
    }


    public function destroy(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.DELETE_NEWS')))  {

            $id = $request->id;
        $news = News::find($id);
        $news->delete($id);

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


    public function destroyAll(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.DELETE_ALL_NEWS'))) {
           

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $news = News::find($id);
               // $news->delete();
               if ($news) {
                $news->delete();

                // Log activity for each deletion
                // activity('news')
                //     ->causedBy(auth()->user())
                //     ->log("News with ID: {$id} has been deleted.");
            }

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

    
    public function updateSortorder(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_NEWS_SORTORDER'))) {
           
        $data = $request->records;
       
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $news = News::find($id);
                $news->sortOrder = $values->position;
                $result = $news->save();
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

    public function updateStatus(Request $request)
    {
        if ((isset(Auth::user()->roleId) && Auth::user()->roleId == 1) || auth()->user()->hasPermission(config('constants.UPDATE_NEWS_STATUS'))) {
           
        
        
        $status = $request->status;
        $id = $request->id;

        $news = News::find($id);
        $news->status = $status;
        $result = $news->save();
      

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


    public function deleteMedia(Request $request)
{
    $mediaId = $request->input('media_id');

    if (!$mediaId) {
        return response()->json(['success' => false, 'message' => 'Media ID is required.']);
    }

    $media = Media::find($mediaId);

    if (!$media) {
        return response()->json(['success' => false, 'message' => 'Media not found.']);
    }


    $media->delete();

    return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
}

    
    
}
