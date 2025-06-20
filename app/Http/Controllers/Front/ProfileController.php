<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function show($type, $id) :View
    {
        // Xác định loại đối tượng
        switch ($type) {
            case 'user':
                $user = User::with('profile')->findOrFail($id);
                $profile = $user->profile;
                $role = 'user';
                break;

            case 'admin':
                $user = Admin::with('profile')->findOrFail($id); // nếu Admin cũng có profile
                $profile = $user->profile;
                $role = 'admin';
                break;

            default:
                abort(404);
        }

        return view('front.content.profile', [
            'user' => $user,
            'profile' => $profile,
            'role' => $role,
        ]);
    }

    public function update(Request $request, $type, $id): RedirectResponse
    {
        // Lấy người dùng theo type
        switch ($type) {
            case 'admin':
                $user = \App\Models\Admin::findOrFail($id);
                $emailRule = Rule::unique('admins', 'email')->ignore($user->id);
                break;
            case 'user':
                $user = \App\Models\User::findOrFail($id);
                $emailRule = Rule::unique('users', 'email')->ignore($user->id);
                break;
            default:
                abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'email' => ['required', 'email', $emailRule],
            'google_id' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);


        $profile = $user->profile;
        $profile->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'google_id' => $request->google_id,
        ]);

        // Cập nhật bảng chính
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Cập nhật thành công!');
    }

    /**
     * Delete the user's admin.
     */
    public function destroy($id): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            $guard = 'admin';
        } elseif (Auth::check()) {
            $guard = 'web';
        } else {
            return redirect('/')->with('error', 'Không xác định được người dùng.');
        }

        $user = Auth::guard($guard)->user();

        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại.');
        }

        // Xoá profile nếu cần
        if ($user->profile) {
            $user->profile->delete();
        }

        // Xoá chính user
        $user->delete();

        // Đăng xuất
        Auth::logout();

        return redirect('/')->with('success', 'Tài khoản của bạn đã được xoá thành công.');
    }

    public function changePassword(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $user = auth()->guard('admin')->user(); // là admin
        } else {
            $user = auth()->user(); // là user
        }

        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại.');
        }

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Mật khẩu cũ không chính xác']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
