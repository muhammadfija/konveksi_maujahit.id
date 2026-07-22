<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            $role = session('admin_role', 'owner');
            $redirectUrl = in_array($role, ['owner', 'keuangan']) ? '/admin/dashboard' : '/admin/pesanan';
            return redirect($redirectUrl);
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_code' => 'required|string',
        ]);

        $admin = Admin::where('login_code', $request->login_code)->first();

        if (!$admin) {
            return back()->with('error', 'Kode akses admin tidak valid. Coba lagi.');
        }

        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_role' => $admin->role
        ]);

        $redirectUrl = in_array($admin->role, ['owner', 'keuangan']) ? '/admin/dashboard' : '/admin/pesanan';
        return redirect($redirectUrl)->with('success', 'Berhasil login sebagai ' . $admin->name);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name', 'admin_role']);
        return redirect('/admin/login');
    }
}
