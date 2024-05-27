<?php

namespace App\Http\Controllers;

use App\Models\password_reset_token;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\reset_password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $makanans = Menu::where('category_id', 1)->get();
        $minumans = Menu::where('category_id', 2)->get();
        $snacks   = Menu::where('category_id', 3)->get();
        $prasmanans   = Menu::where('category_id', 4)->get();

        $order = session()->get('order', []);
        $total = 0;
        $totalseller = User::where('role', 'seller')->count();
        $totalfood = Menu::where('category_id', '1')->count();  
        $totaldrink = Menu::where('category_id', '2')->count();  
        $totalsnack = Menu::where('category_id', '3')->count();  
          

        foreach ($order as $id => $order_detail) {
            $subtotal = isset ($order_detail['subtotal']) ? $order_detail['subtotal'] : 0;
            $subtotal += $order_detail['quantity'] * $order_detail['menu_price'];
            $order[$id]['subtotal'] = $subtotal;
            $total += $subtotal;
        }
        session()->put('order', $order);  // Update the session with new subtotal values

        return view('frontend.customer.homepage', compact('makanans','prasmanans', 'minumans', 'snacks', 'order', 'total','totalseller','totalfood','totaldrink','totalsnack'));

    }
    public function menu(Request $request)
    {
        $categories = Category::all();
        $sellers = User::where('role', 'seller')->get();
        $search = $request->input('search');

        if ($search) {
            $menus = Menu::where('menu_name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $menus = Menu::all();
        }
        return view('frontend.customer.page.page_menu', compact('categories', 'menus', 'search', 'sellers'));
    }
    public function filterMenu(Request $request)
    {
        $categories = Category::all();
        $category = $request->input('category');
        $sellers = User::where('role', 'seller')->get();
        $seller = $request->input('seller');
        $menus = Menu::query();

        if ($category) {
            $menus->where('category_id', $category);
        }

        if ($seller) {
            $menus->where('users_id', $seller);
        }

        $menus = $menus->get();

        return view('frontend.customer.page.page_menu', compact('menus', 'categories', 'sellers'));
    }

    public function about()
    {
        return view('frontend.customer.page.page_about');
    }
    public function contact()
    {
        return view('frontend.customer.page.page_contact');
    }

    function forgot_password(){
        return view('account/forgot');
    }

    function forgot_password_act(Request $request){

        $custompesan = [
            'email.required'=>'email tidak boleh kosong',
            'email.email'=>'email tidak valid',
            'email.exists'=>'email tidak terdaftar',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $custompesan);

        $token = Str::random(60);

        password_reset_token::updateOrCreate([
            'email' => $request->email,
        ],
        [
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->email)->send(new reset_password($token));

        $forgot = [
            'email'=>$request->email
        ];  

        return redirect()->route('forgot.password')->with('success', 'Kami Telah Mengirimkan link reset Password Ke Email Anda');
    }

    function reset_password(Request $request, $token){
        
        $getToken = password_reset_token::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('auth')->with('failed', 'Token Tidak Valid');
        }

        return view('account/resetpw', compact('token'));
    }

    function resetpasswordact(Request $request){
        $custompw = [
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Minimal 6 Huruf',
        ];
        
        $request->validate([
            'password' => 'required|min:6'
        ], $custompw);
        
        $token = $request->token;
        
        $password_reset_token = password_reset_token::where('token', $token)->first();
        
        if (!$password_reset_token) {
            return redirect()->route('auth')->with('failed', 'Token Tidak Valid');
        }
        
        $user = User::where('email', $password_reset_token->email)->first();
        
        if (!$user) {
            return redirect()->route('auth')->with('failed', 'Email Tidak Terdaftar');
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        // Hapus token setelah digunakan
        $password_reset_token->delete();
        
        return redirect()->route('auth')->with('success', 'Password Berhasil Diubah');
        
        
    }

}