<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use App\Models\Admin\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MenuManagerController extends Controller
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

        $data["menu"] = Menu::orderBy('sortOrder')->get();
      
        $data["pageTitle"] = 'Manage Menu';
        $data["activeMenu"] = 'Menu Manager';
        return view('admin.menu.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Menu';
        $data["activeMenu"] = 'Menu Manager';
        return view('admin.menu.create')->with($data);
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
            'name' => 'required'
        ]);

        $menu = new Menu();

            $menu->name = $request->input('name');
            $menu->page = $request->input('page');
            $menu->slug = Str::slug($request->input('name'));
           
        $menu->status = 1;
        $menu->sortOrder = 1;

        $menu->increment('sortOrder');

        $menu->save();

        return redirect()->route('menu.index')->with('message', 'Menu Added Successfully');
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

        $data['menu'] = Menu::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Menu';
        $data["activeMenu"] = 'Menu Manager';
        return view('admin.menu.create')->with($data);
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
            'name' => 'required'
        ]);
        
        $id = $request->input('id');

        $menu = Menu::find($id);

        

        $menu->name = $request->input('name');
        $menu->slug = Str::slug($request->input('name'));
        $menu->page = $request->input('page');
        $menu->save();

        return redirect()->route('menu.index')->with('message', 'menu Updated Successfully');
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
        $menu = Menu::find($id);
        $menu->delete($id);

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
                $menu = Menu::find($id);
                $menu->delete();
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
                $menu = Menu::find($id);
                $menu->sortOrder = $values->position;
                $result = $menu->save();
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

        $menu = Menu::find($id);
        $menu->status = $status;
        $result = $menu->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }


    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = [];


        foreach ($elements as $value) {
            if ($value['parent_id'] == $parentId) {
               
                $children = $this->buildTree($elements, $value['id']);

                if (!empty($children)) {
                    $value['children'] = $children;
                }

                $branch[] = $value;
            }
        }

        return $branch;
    }



    public function cleanArray($array){
    
        $i=0;
        foreach($array as $value) {
       
                $cleanedArray[$i]['href'] = $value['url'];
                $cleanedArray[$i]['icon'] = $value['icon'];
                $cleanedArray[$i]['text'] = $value['title'];
                $cleanedArray[$i]['target'] = $value['target'];
                $cleanedArray[$i]['title'] = $value['tooltip'];
                
                    
                            if(isset($value['children'])){
                            
                            if(is_array($value['children'])){
                            
                            
                            $cleanedArray[$i]['children'] = $this->cleanArray($value['children']);
                            
                            
                            } 
                            
                            }
                
        $i++;}
                    
        return $cleanedArray;
        
    }




    public function menu_items($menuId)
    {
    
        $menu = Menu::with('items')->findOrFail($menuId);
        // echo '<pre>';
        // print_r($menu);
        // die();
        $data['jsonString'] = '';
    
        if ($menu->items->isNotEmpty()) {
          
            $menuItemArray = $menu->items->toArray();
          
            $tree = $this->buildTree($menuItemArray);
            
    
            $cleaned = $this->cleanArray($tree);
           
    
            $data['jsonString'] = json_encode($cleaned);
            // echo '<pre>';
            // print_r( $data['jsonString']);
            // die();
        }
    
        $data['menuId'] = $menuId;
        $data['menu'] = $menu;
        $data['activeMenu'] = 'Menu Manager';
     
        return view('admin.menu.menu_items', $data);
    }



    public function addMenuItems(Request $request)
    {
        $str = $request->input('str');
        $menuId = $request->input('menuId');

        $itemArray = json_decode($str, true);

        MenuItem::where('menu_id', $menuId)->delete();

        if ($this->recursiveSave($menuId, $itemArray)) {
            return response()->json(['Status' => 1]);
        } else {
            return response()->json(['Status' => 0]);
        }
    }

   
    private function recursiveSave($menuId, array $items, $parentId = 0)
    {
        foreach ($items as $item) {
           
            $menuItem = new MenuItem();
            $menuItem->menu_id = $menuId;
            $menuItem->parent_id = $parentId;
            $menuItem->title = $item['text'] ?? ''; 
            $menuItem->url = $item['url'] ?? '';
            $menuItem->icon = $item['icon'] ?? '';
            $menuItem->target = $item['target'] ?? '';
            $menuItem->tooltip = $item['tooltip'] ?? '';
            $menuItem->save();


            if (isset($item['children']) && is_array($item['children'])) {
                $this->recursiveSave($menuId, $item['children'], $menuItem->id);
            }
        }

        return true;
    }
    

}
