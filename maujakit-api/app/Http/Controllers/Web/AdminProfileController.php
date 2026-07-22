<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::findOrFail(session('admin_id'));
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Admin::findOrFail(session('admin_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'login_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('admins')->ignore($admin->id),
            ],
        ]);

        $admin->update([
            'name' => $request->name,
            'login_code' => $request->login_code,
        ]);

        // Update session name in case it changed
        session(['admin_name' => $request->name]);

        return redirect('/admin/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
