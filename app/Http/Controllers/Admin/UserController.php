<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Vtiful\Kernel\Excel;

class UserController extends Controller
{
    public function index(Request $request)
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

    public function create()
    {
        return view('admin.content.user.create', [
            'page' => 'manage-user',
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào, lỗi validation sẽ tự động trả về trang trước đó với thông báo lỗi
        $credentials = $request->validate([
            // các rule
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'max:255'],
            'password' => ['required', 'min:8'],
            'google_id' => ['nullable', 'max:255', 'unique:users,google_id'],
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
                'google_id.max' => 'Google ID không được vượt quá 255 ký tự',
                'google_id.unique' => 'Google ID đã tồn tại trong hệ thống',
            ]);

        try {
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password']),
                'google_id' => $credentials['google_id'] ?? null,
            ]);

            return redirect()->route('admin.user.index')->with('success', 'Thêm mới học sinh thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Thêm mới học sinh thất bại: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.content.user.edit', [
            'page' => 'manage-user',
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

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

        // Validate thông tin profile (nếu có)
        $profileData = $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'phone' => ['nullable', 'max:10'],
            'birthday' => ['nullable', 'date'],
            'address' => ['nullable', 'max:255'],
        ], [
            'avatar.image' => 'Ảnh đại diện phải là hình ảnh',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự',
            'birthday.date' => 'Ngày sinh không hợp lệ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        ]);

        try {
            // Cập nhật user
            $user->update([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
            ]);


            // Cập nhật profile (nếu đã có)
            if ($user->profile) {
                $user->profile->update($profileData);
            } else {
                $user->profile()->create($profileData);
            }

            return redirect()->route('admin.user.index')->with('success', 'Cập nhật thông tin người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->input('del-object-id'));
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'Xóa học sinh thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Xóa học sinh thất bại: ' . $e->getMessage());
        }
    }


    public function resetPassword($id){

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's password to '123456789'
        $user->password = Hash::make('123456789');

        // Save the changes to the database
        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'Đặt lại mật khẩu thành công!');
    }

    public function export(Request $request){
        return Excel::download(new UsersExport($request), 'Danh sách học sinh.xlsx');
    }

    public function showProfileForm($id)
    {
        $user = User::findOrFail($id);

        return view('admin.content.user.detail', [
            'user' => $user,
        ]);
    }

    public function storeProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'phone' => ['required', 'max:10'],
            'birthday' => ['required', 'date'],
            'address' => ['required', 'max:255'],
        ], [
            'avatar.image' => 'Ảnh đại diện phải là một tệp hình ảnh',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png hoặc jpg',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự',
            'birthday.required' => 'Vui lòng nhập ngày sinh',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        ]);

        try {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $user->profile()->create([
                'avatar' => $avatarPath,
                'phone' => $validated['phone'],
                'birthday' => $validated['birthday'],
                'address' => $validated['address'],
            ]);

            return redirect()->route('admin.user.index')->with('success', 'Thông tin profile đã được lưu thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi lưu thông tin profile: ' . $e->getMessage());
        }
    }
}
