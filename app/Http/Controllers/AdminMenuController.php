<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;

class AdminMenuController extends Controller
{
    // MENU RESOURCE METHODS
    public function index()
    {
        $menus = Menu::with('category')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048' // Only jpg/png, max 2MB
        ]);

        $menu = new Menu($request->only(['name', 'price', 'description', 'category_id']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/menus'), $filename);
            $menu->image = $filename;
        }

        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        return response()->json($menu); // Untuk modal edit via AJAX
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048' // Only jpg/png, max 2MB
        ]);

        $menu->update($request->only(['name', 'price', 'description', 'category_id']));

        if ($request->hasFile('image')) {
            if ($menu->photo && file_exists(public_path('uploads/menus/'.$menu->photo))) {
                unlink(public_path('uploads/menus/'.$menu->photo));
            }
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/menus'), $filename);
            $menu->photo = $filename;
            $menu->save();
        }

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->photo && file_exists(public_path('uploads/menus/'.$menu->photo))) {
            unlink(public_path('uploads/menus/'.$menu->photo));
        }
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }

    // CATEGORY METHODS
    public function categoryIndex()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function categoryUpdate(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function categoryDestroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
