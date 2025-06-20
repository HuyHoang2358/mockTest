<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class ProfileAdminController extends Controller
{
    public function show(): RedirectResponse|View
    {
        $user = Auth::user()->load('profile');

        return view('admin.content.account.profileAdmin', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user()->load('profile');

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($user->id)],
            'google_id' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);


        $profileData  = [
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
        ];

        if (!empty($request->avatar)) {
            $profileData['avatar'] = $request->avatar;
        }

        $profile = $user->profile;
        $profile->update($profileData);

        // Cập nhật bảng chính
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Cập nhật thành công!');
    }


    public function destroy(Request $request) :RedirectResponse
    {

        $user = auth()->guard('admin')->user();
        // Xoá profile nếu cần
        if ($user->profile) {
            $user->profile->delete();
        }

        Auth::logout();

        // xóa session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        try {
            $user->delete();
            return redirect('/')->with('success', 'Xóa tài khoản thành công!');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Xóa tài khoản thất bại: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $user = Auth::user()->load('profile');

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

        Auth::logout();
        Session::flush();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function personal_change_image(Request $request){

        $user = Auth::user()->load('profile');

        if(isset($request->avatar)){
            $user->profile()->update([
                'avatar' => $request->avatar,
            ]);

            return redirect()->route('admin.show')->with('success', 'Cập nhật ảnh đại diện thành công! ');
        }
    }
}
