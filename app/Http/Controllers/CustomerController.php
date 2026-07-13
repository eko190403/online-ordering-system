<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function showRegister()
    {
        return view('customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'points' => 0,
        ]);

        Auth::login($user);
        
        // WhatsApp Notification Simulation
        if ($user->phone) {
            Log::channel('single')->info("[WHATSAPP SIMULATION] To: {$user->phone} - Halo {$user->name}, selamat datang di Cafe D.Villa! Dapatkan poin dari setiap pesananmu.");
        }

        return redirect()->route('menu.index')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function showLogin()
    {
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'customer']))) {
            $request->session()->regenerate();
            return redirect()->route('menu.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function profile()
    {
        $user = auth()->user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return view('customer.profile', compact('user', 'orders'));
    }
}
