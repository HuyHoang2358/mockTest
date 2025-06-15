<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenController extends Controller
{
    public function login(): View
    {
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        // Validate dữ liệu đầu vào, lỗi validation sẽ tự động trả về trang trước đó với thông báo lỗi
        $credentials = $request->validate([
            // các rule
            'email' => ['required', 'email', 'exists:admins,email'],
            'password' => ['required', 'min:6'],
        ],
        [
            // các thông báo lỗi
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        // Thử đăng nhập với guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            // Đăng nhập thành công
            return redirect()->route('admin.dashboard');
        }

        // Đăng nhập thất bại - quay về với lỗi
        return back()->withErrors([
            'password' => 'Mật khẩu không đúng.',
        ])->withInput();
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

}
