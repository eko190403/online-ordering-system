<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Check operating hours
        $currentHour = now()->format('H:i');
        $openTime = config('cafe.open_time', '08:00');
        $closeTime = config('cafe.close_time', '22:00');
        $isClosed = $currentHour < $openTime || $currentHour >= $closeTime;
        
        $categories = Category::with('menus')->get();
        
        // Search functionality
        $search = $request->input('search');
        $menus = Menu::with(['category', 'stock'])
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->get();
            
        return view('menu.index', compact('categories', 'menus', 'isClosed', 'openTime', 'closeTime'));
    }

    public function byCategory($category = null, Request $request)
    {
        // Check operating hours
        $currentHour = now()->format('H:i');
        $openTime = config('cafe.open_time', '08:00');
        $closeTime = config('cafe.close_time', '22:00');
        $isClosed = $currentHour < $openTime || $currentHour >= $closeTime;
        
        $categories = Category::with('menus')->get();
        
        // Search functionality
        $search = $request->input('search');
        
        if ($category) {
            $menus = Menu::where('category_id', $category)
                ->with(['category', 'stock'])
                ->when($search, function($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                })
                ->get();
        } else {
            $menus = Menu::with(['category', 'stock'])
                ->when($search, function($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                })
                ->get();
        }
        
        return view('menu.index', compact('categories', 'menus', 'isClosed', 'openTime', 'closeTime'));
    }
}
