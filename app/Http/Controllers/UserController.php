<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Auth Methods
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    // Tampilkan daftar menu
    public function menu()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    // Tambahkan menu ke cart
    public function addToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan ke cart');
    }

    // Tampilkan cart
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Checkout pesanan
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        if(!$cart || count($cart) == 0){
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        // Buat order baru
        $order = Order::create([
            'order_code' => 'ORD'.strtoupper(uniqid()),
            'user_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'status' => 'diproses',
            'total_price' => array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart))
        ]);

        // Simpan order items
        foreach($cart as $id => $item){
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['qty']
            ]);
        }

        // Hapus cart session
        session()->forget('cart');

        return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibuat');
    }

    // Tampilkan semua order
    public function orders()
    {
        $orders = Order::with('items.menu')->get();
        return view('orders.index', compact('orders'));
    }
}