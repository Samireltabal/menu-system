<?php

namespace SamirEltabal\MenuSystem\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use SamirEltabal\MenuSystem\Models\MenuItem;
use SamirEltabal\MenuSystem\Models\Menu;
class MenuController extends Controller
{
    public function __construct() {
        $middlewares = config('menu.admin_middleware');
        $this->middleware($middlewares)->only([ 
            'create_menu', 
            'list_menus',
            'delete_menu',
            'disable_menu',
            'enable_menu',
            'getIcons',
            'getIconGroups',
            'getItemTypes'
            ]);
    }

    public function create_menu(Request $request) {
        $validation = $request->validate([
            'menu_name' => 'required|unique:menus,menu_name',
            'component_name' => 'max:18'
        ]);
        $data = $request->only(['menu_name', 'active', 'component_name']);
        $data['slug'] = $request->input('menu_name');
        $menu = Menu::create($data);

        return response()->json($menu, 201);
    }


    public function list_menus(Request $request) {
        $menus = Menu::all();
        return response()->json($menus, 200);
    }

    public function get_menu($slug) {
        try {
            $menu = Menu::slug($slug)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        return response()->json($menu, 200);
    }

    public function delete_menu($slug) {
        try {
            $menu = Menu::FindBySlug($slug)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        $menu->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ], 200);
    }

    public function disable_menu($slug) {
        try {
            $menu = Menu::FindBySlug($slug)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        $menu->disable()->save();
        return response()->json($menu, 200);
    }

    public function enable_menu($slug) {
        try {
            $menu = Menu::FindBySlug($slug)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        $menu->enable()->save();
        return response()->json($menu, 200);
    }

    public function create_menu_item(Request $request) {
        $types = collect(config('menu.available_types'))->toArray();
        $types = implode(',', $types);
        $validation = $request->validate([
            'text' => 'required',
            'route' => 'required',
            // 'parent_id' => 'exists:menu_items,id',
            'menu_id' => 'required|exists:menus,id',
            'type' => "required|in:" . $types
        ]);
        $item = MenuItem::create($request->all());
        return response()->json($item, 201);
    }

    public function delete_menu_item($id) {
        try {
            $menu = MenuItem::where('id', '=', $id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        \DB::beginTransaction();
        try {
            if($menu->HasChild) {
                foreach ($menu->children as $child) {
                    $child->parent_id = null;
                    $child->save();
                }
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json($th, 400);    
        }
        if($menu->delete()) {
            \DB::commit();
            return response()->json([
                'message' => 'successfully deleted'
            ], 200);
        } else {
            \DB::rollback();
            return response()->json([
                'message' => 'something went wrong'
            ], 400);
        }
    }

    public function update_order (Request $request) {
        $validation = $request->validate([
            'id' => 'required|exists:menu_items,id',
            'order' => 'required|numeric'
        ]);
        $item = MenuItem::find($request->input('id'));
        $item = $item->setOrder($request->input('order'));
        if($item) {
            return response()->json($item, 200);
        } else {
            return respone()->json([
                'message' => 'something went wrong'
            ], 400);
        }
    }

    public function update_parent (Request $request) {
        $validation = $request->validate([
            'id' => 'required|exists:menu_items,id',
        ]);
        $item = MenuItem::find($request->input('id'));
        $item = $item->setParent($request->input('parent_id'));
        if($item) {
            return response()->json($item, 200);
        } else {
            return respone()->json([
                'message' => 'something went wrong'
            ], 400);
        }
    }

    public function update_visibility (Request $request) {
        $levels = collect(config('menu.visibility_levels'))->toArray();
        $levels = implode(',', $levels);
        $validation = $request->validate([
            'id' => 'required|exists:menu_items,id',
            'visibility_level' => 'required|in:' . $levels
        ]);
        $item = MenuItem::find($request->input('id'));
        $item = $item->setVisibility($request->input('visibility_level'));
        if($item) {
            return response()->json($item, 200);
        } else {
            return response()->json([
                'message' => 'something went wrong'
            ], 400);
        }
    }


    public function getIcons () {
        $icons = config('menu.icons_available');
        return response()->json($icons, 200);
    }

    public function getIconGroups () {
        $icons = config('menu.icon_groups');
        return response()->json($icons, 200);
    }

    public function getComponents () {
        $components = config('menu.available_components');
        return response()->json($components, 200);
    }

    public function getItemTypes () {
        $types = config('menu.available_types');
        return response()->json($types, 200);
    }

    public function getVisibilityLevels () {
        $levels = config('menu.visibility_levels');
        return response()->json($levels, 200);
    }
}
