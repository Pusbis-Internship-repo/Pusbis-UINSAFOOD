<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $makanans = Menu::where('category_id', 1)->get();
        $minumans = Menu::where('category_id', 2)->get();
        $snacks   = Menu::where('category_id', 3)->get();
        $prasmanans   = Menu::where('category_id', 4)->get();

        $order = session()->get('order', []);
        $userId = auth()->id();
        $lastOrder = Order::where('users_id', $userId)->latest()->first();
        $userOrders = Order::where('users_id', $userId)->get();
        $total = 0;
        $menuDetail = [];
        $uniqueMenus = collect([]);
    
        foreach ($order as $id => $order_detail) {
            $subtotal = isset($order_detail['subtotal']) ? $order_detail['subtotal'] : 0;
            $subtotal += $order_detail['quantity'] * $order_detail['menu_price'];
            $order[$id]['subtotal'] = $subtotal;
            $total += $subtotal;
        }
    
        if ($lastOrder) {
            $menuDetail = Menu::findOrFail($lastOrder->menu_id);
            $uniqueMenus = $userOrders->unique('menu_id')->map(function ($order) {
                return Menu::findOrFail($order->menu_id);
            });
        }

        $userReview = null;
        if ($lastOrder) {
            $userReview = Review::where('users_id', auth()->id())
                ->where('id_pesanan', $lastOrder->id_pesanan)
                ->first();
        }
    
        session()->put('order', $order);  // Update the session with new subtotal values
        return view('pointakses/user/index', compact('menus', 'makanans','prasmanans', 'minumans', 'snacks', 'order', 'lastOrder', 'userOrders', 'total', 'menuDetail', 'uniqueMenus', 'userReview'));
    }
    
    public function addRatingReview(Request $request, $id_pesanan)
    {
        // Periksa apakah pengguna telah login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk memberikan rating dan ulasan.');
        }

        // Periksa apakah pesanan dengan id yang diberikan dimiliki oleh pengguna yang sedang login
        $userId = Auth::id();
        $order = Order::where('id_pesanan', $id_pesanan)->where('users_id', $userId)->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan rating dan ulasan untuk pesanan yang sudah Anda buat.');
        }
    
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Simpan rating dan ulasan ke dalam database
        $review = new Review([
            'menu_id' => $order->menu_id,
            'users_id' => auth()->id(),
            'id_pesanan' => $id_pesanan, // Menambahkan id_pesanan ke dalam review
            'rating' => $request->rating,
            'comment' => $request->review,
        ]);
    
        $review->save();
    
        return redirect()->back()->with('success', 'Rating dan ulasan berhasil ditambahkan.');
    }

    public function menu_user(Request $request)
    {
        $categories = Category::all();
        $sellers = User::where('role', 'seller')->get();
        $search = $request->input('search');
    
        if ($search) {
            $menus = Menu::where('menu_name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $menus = Menu::all();
        }

        return view('pointakses/user/page_menu', compact('categories', 'menus', 'search', 'sellers'));
    }

    public function filterMenu_user(Request $request)
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

        return view('pointakses/user/page_menu', compact('menus', 'categories', 'sellers'));
    }

    public function about_user()
    {
        return view('pointakses/user/page_about');
    }
    public function contact_user()
    {
        return view('pointakses/user/page_contact');
    }
    public function menuOrder()
    {
        return view('pointakses/user/order');
    }

    public function addMenutoOrder($id)
    {
        // Ensure the user is authenticated
        $this->middleware('auth');

        $menu = Menu::findOrFail($id);
        $userId = auth()->id();

        // Get the user's cart from the session
        $order = session()->get("order_$userId", []);

        if (isset($order[$id])) {
            $order[$id]['quantity']++;
            $order[$id]['subtotal'] = $order[$id]['quantity'] * $order[$id]['menu_price'];
        } else {
            $order[$id] = [
                "menu_id" => $menu->id,
                "menu_name" => $menu->menu_name,
                "seller" => $menu->seller,
                "menu_pic" => $menu->menu_pic,
                "quantity" => 1,
                "menu_price" => $menu->menu_price,
                "menu_desc" => $menu->menu_desc,
                "subtotal" => $menu->menu_price,
                "min_order_time" => $menu->min_order_time
            ];
        }

        // Store the updated cart in the user's session
        session()->put("order_$userId", $order);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function updateorder(Request $request)
    {
        $this->middleware('auth');

        $userId = auth()->id();

        if ($request->id && $request->quantity) {
            // Get the user's cart from the session
            $order = session()->get("order_$userId");

            if (isset($order[$request->id])) {
                $order[$request->id]["quantity"] = $request->quantity;
                // Recalculate subtotal when updating quantity
                $order[$request->id]["subtotal"] = $request->quantity * $order[$request->id]["menu_price"];
                // Store the updated cart in the user's session
                session()->put("order_$userId", $order);
                session()->flash('success', 'Product quantity updated.');
            }
        }
    }

    public function deleteMenu(Request $request)
    {
        $this->middleware('auth');

        $userId = auth()->id();

        if ($request->id) {
            // Get the user's cart from the session
            $order = session()->get("order_$userId");

            if (isset($order[$request->id])) {
                unset($order[$request->id]);
                // Store the updated cart in the user's session
                session()->put("order_$userId", $order);
            }

            session()->flash('success', 'Menu successfully deleted.');
        }
    }

    public function checkout()
    {
        $order = Session::get("order_" . auth()->id(), []);
        $total = $this->calculateTotal($order);

        return view('pointakses/user/checkout', compact('order', 'total'));
    }

    private function calculateTotal($order)
    {
        $total = 0;

        foreach ($order as $id => $order_detail) {
            $total += $order_detail['subtotal'];
        }

        return $total;
    }
    public function history_order(Request $request)
    {
        $userId = Auth::id();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $groupedOrdersQuery = DB::table('orders')
            ->select(
                'id_pesanan',
                'total',
                'nama_penerima',
                'alamat_pengiriman',
                'fakultas',
                'tanggal',
                'jam',
                'status',
                DB::raw('GROUP_CONCAT(CONCAT(menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->where('users_id', $userId);

        if ($startDate && $endDate) {
            $groupedOrdersQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $groupedOrders = $groupedOrdersQuery
            ->orderBy('id_pesanan', 'desc')
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'status')
            ->get();

        return view('pointakses/user/history_order', ['groupedOrders' => $groupedOrders]);
    }

    public function invoice($id_pesanan)
    {
        $userId = Auth::id();

        // Retrieve the grouped orders
        $groupedOrders = DB::table('orders')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select(
                'id_pesanan',
                'total',
                'nama_penerima',
                'alamat_pengiriman',
                'fakultas',
                'tanggal',
                'jam',
                'users.nama_lengkap',
                'status',
                'catatan',
                DB::raw('GROUP_CONCAT(menu_name) as menu_names'),
                DB::raw('GROUP_CONCAT(seller) as sellers'),
                DB::raw('GROUP_CONCAT(menu_price) as menu_prices'),
                DB::raw('GROUP_CONCAT(subtotal) as subtotals'),
                DB::raw('GROUP_CONCAT(quantity SEPARATOR ", ") as quantities')
            )
            ->where('users_id', $userId)
            ->where('id_pesanan', $id_pesanan)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status', 'catatan')
            ->get();

        // Return the view with the data
        return view('pointakses.user.invoice', compact('userId', 'groupedOrders'));
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~   Method Profile   ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\\

    public function editprofile()
    {
        return view('pointakses/user/editprofile');
    }

    public function updateprofile(Request $request)
    {
        $users = auth()->user();
        $users->nama_lengkap = $request->input('nama_lengkap');
        $users->email = $request->input('email');
        $users->no_tlp = $request->input('no_tlp');
        $users->alamat = $request->input('alamat');
        $users->unit_kerja = $request->input('unit_kerja');
        $users->save();

        return back()->with('message', 'Update Profile Berhasil');
    }

    public function editpassword()
    {
        return view('pointakses/user/changepassword');
    }

    public function updatepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('change.password')
                ->withErrors($validator)
                ->withInput();
        }

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('change.password')
                ->with('error', 'Password lama tidak valid.')
                ->withInput();
        }

        // Update password baru
        auth()->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui.');
    }
}
