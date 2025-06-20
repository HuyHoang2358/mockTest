<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Vtiful\Kernel\Excel;

class UserController extends Controller
{
    public function index(Request $request) :View
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $wildcardSearch = '%' . implode('%', str_split($search)) . '%';

                return $query->where('name', 'LIKE', $wildcardSearch)
                    ->orWhere('email', 'LIKE', $wildcardSearch);
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        return view('admin.content.user.index', [
            'page' => 'manage-user',
            'users' => $users,
            'routeSearch' => route('admin.user.index'),
        ]);
    }

    public function create() :View
    {
        return view('admin.content.user.create', [
            'page' => 'manage-user',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate dữ liệu đầu vào, lỗi validation sẽ tự động trả về trang trước đó với thông báo lỗi
        $credentials = $request->validate([
            // các rule
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'max:255'],
            'password' => ['required', 'min:8'],
        ],
            [
                // các thông báo lỗi
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'name.required' => 'Vui lòng nhập name',
                'name.max' => 'Tên không được vượt quá 255 ký tự',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            ]);

        try {
            // Tạo mới user
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'google_id' => $credentials['google_id'] ?? null,
            ]);

            // Tao mới profile cho user
            $user->profile()->create([
                'avatar' => null,
                'phone' => null,
                'birthday' => null,
                'address' => null,
            ]);


            return redirect()->route('admin.user.index')->with('success', 'Thêm mới học sinh thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id): View|RedirectResponse
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('admin.user.index')->with('error', 'Người dùng không tồn tại.');

        return view('admin.content.user.edit', [
            'page' => 'manage-user',
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('admin.user.index')->with('error', 'Người dùng không tồn tại.');


        // Validate thông tin user (name, email)
        $credentials = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'name' => ['required', 'max:255'],
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
        ]);
        try {
            $user->update([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
            ]);
            return redirect()->route('admin.user.index')->with('success', 'Cập nhật thông tin người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request) : RedirectResponse
    {
        $user = User::find($request->input('del-object-id'));
        if (!$user) return redirect()->route('admin.user.index')->with('error', 'Người dùng không tồn tại.');

        try {
            $user->profile()->delete(); // Xóa profile liên quan
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'Xóa học sinh "'.$user->name.'" thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }


    public function resetPassword($id): RedirectResponse
    {

        // Find the user by ID
        $user = User::find($id);
        if (!$user) return redirect()->route('admin.user.index')->with('error', 'Người dùng không tồn tại.');


        // Update the user's password to '123456789'
        $user->password = Hash::make('123456789');

        // Save the changes to the database
        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'Đặt lại mật khẩu cho tài khoản "'.$user->name.'" thành công!');
    }
}
