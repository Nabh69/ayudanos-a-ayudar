<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller {
 public function login(Request $r) { $data=$r->validate(['email'=>'required|email','password'=>'required|string']);if(!Auth::attempt($data)) return back()->withErrors(['email'=>'El correo o la contraseña no son correctos.'])->onlyInput('email');$r->session()->regenerate();return redirect()->intended('/panel'); }
 public function register(Request $r) { $d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:200|unique:users','password'=>'required|string|min:10|confirmed','consent'=>'accepted']);$u=User::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make($d['password'])]);Auth::login($u);$r->session()->regenerate();return redirect('/panel'); }
 public function logout(Request $r) {Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
}
