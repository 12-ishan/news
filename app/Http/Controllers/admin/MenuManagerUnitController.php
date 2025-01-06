<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use App\Models\Admin\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MenuManagerUnitController extends Controller
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
        $data["activeMenu"] = 'Custom Menu Manager';
        return view('admin.menuUnit.manage')->with($data);
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
        $data["activeMenu"] = 'Custom Menu Manager';
        return view('admin.menuUnit.create')->with($data);
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

        return redirect()->route('menu-unit.index')->with('message', 'Menu Added Successfully');
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
        return view('admin.menu-unit.create')->with($data);
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

        return redirect()->route('menu-unit.index')->with('message', 'menu Updated Successfully');
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


    public function buildTree($elements, $parentId = 0)
    {
        $branch = [];
    
        foreach ($elements as $value) {
            // Ensure $value is an array and contains the expected keys
            if (is_array($value) && isset($value['parent_id'], $value['id'])) {
                if ($value['parent_id'] == $parentId) {
                    $children = $this->buildTree($elements, $value['id']);
    
                    if (!empty($children)) {
                        $value['children'] = $children;
                    }
    
                    $branch[] = $value;
                }
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
       // $menu = Menu::with(['items.children'])->findOrFail($menuId); 
       $menu = Menu::with([
        'items' => function ($query) {
            $query->orderBy('sortOrder'); 
        },
        'items.children' => function ($query) {
            $query->orderBy('sortOrder'); 
        }
    ])->findOrFail($menuId);
    
        $items = $menu->items; 
        
        $data['menu'] = $menu;
        $data['items'] = $items; 
        $data['menuId'] = $menuId;
        $data["pageTitle"] = 'Manage Menu Items';
        $data["activeMenu"] = 'Custom Menu Manager';
    
        return view('admin.menuUnit.menu_items', $data);
    }

    public function addMenuItems($menuId)
    {
        $data = array();
        $data["parentMenuItem"] = MenuItem::where('status',1)->get();
        // echo '<pre>';
        // print_r($data['parentMenuItem']);
        // die();
        $data['menuId'] = $menuId;
        // echo '<pre>';
        // print_r($data['menuId']);
        // die();
       
        $data["pageTitle"] = 'Add Menu Items';
        $data["activeMenu"] = 'Custom Menu Manager';
        return view('admin.menuUnit.add-menu-items')->with($data);
    }


    public function storeMenuItems(Request $request)
    {
       
        $this->validate(request(), [
            'title' => 'required',
 
        ]);

        $menuItem = new MenuItem();

        $menuItem->menu_id = $request->input('menuId');
       
        $menuItem->title = $request->input('title');
       
        $menuItem->parent_id = $request->input('parentId');
        $menuItem->url = $request->input('url');
        $menuItem->target = $request->input('target');
        $menuItem->sortOrder = $request->input('sortOrder');
       
        $menuItem->status = 1;

        $menuItem->save();

        return redirect()->route('menu-unit.menu-items', ['id' => $menuItem->menu_id])
        ->with('message', 'Menu item Added Successfully');
    
    }


    public function editMenuItems($id)
    {
        $data = array();
       
      $data["parentMenuItem"] = MenuItem::where('status',1)->orderBy('sortOrder')->get();
      $data['menuItem'] = MenuItem::find($id);
      echo '<pre>';
      print_r($data['menuItem']);
      die();
      $data['menuId'] = MenuItem::where('id', $id)->value('menu_id');


        $data["editStatus"] = 1;
       
        $data["pageTitle"] = 'Edit Menu Items';
        $data["activeMenu"] = 'Custom Menu Manager';
        return view('admin.menuUnit.add-menu-items')->with($data);
    }


    public function updateMenuItems(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // die();
       
        $this->validate(request(), [
            'title' => 'required',
 
        ]);

        $id = $request->input('id');
    $menuItem = MenuItem::find($id);


        $menuItem->menu_id = $request->input('menuId');
       
        $menuItem->title = $request->input('title');
       
        $menuItem->parent_id = $request->input('parentId');
        $menuItem->url = $request->input('url');
        $menuItem->target = $request->input('target');
        $menuItem->sortOrder = $request->input('sortOrder');
       
        $menuItem->status = 1;

        $menuItem->save();

        return redirect()->route('menu-unit.menu-items', ['id' => $menuItem->menu_id])
        ->with('message', 'Menu item Added Successfully');
    
    }


    public function deleteMenuItems(Request $request)
    {
       
        $id = $request->id;
        $menu = MenuItem::find($id);
        $menu->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
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
