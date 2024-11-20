<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function login(){

        return view('login');
    }

    public function home(){

        return view('home');
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)){
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('failed', 'proses login gagal, coba lagi!');
        }
    }

    public function logout() 
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'logout berhasil, silahkan datang kembali :D');
    }

    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
        ]);

        $email = substr($request->email, 0, 3);
        $nama = substr($request->name, 0, 3); 
        $generatedPassword = $email . $nama;

        // $dataPassword = $request->str_random(10);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($generatedPassword),
            'role' => $request->role,
        ]);

        
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|string|in:admin,user,kasir',
            'password' => '',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
?>