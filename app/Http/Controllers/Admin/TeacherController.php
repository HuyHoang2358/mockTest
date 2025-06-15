<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Vtiful\Kernel\Excel;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Admin::query()
            ->when($search, function ($query, $search) {
                $wildcardSearch = '%' . implode('%', str_split($search)) . '%';

                return $query->where('name', 'LIKE', $wildcardSearch)
                    ->orWhere('email', 'LIKE', $wildcardSearch);
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        return view('admin.content.teacher.index', [
            'page' => 'manage-teacher',
            'teachers' => $teachers,
            'routeSearch' => route('admin.teacher.index'),
        ]);
    }

    public function create()
    {
        return view('admin.content.teacher.create', [
            'page' => 'manage-teacher',
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào, lỗi validation sẽ tự động trả về trang trước đó với thông báo lỗi
        $credentials = $request->validate([
            // các rule
            'email' => ['required', 'email', 'unique:admins,email'],
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
            Admin::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password']),
            ]);
            return redirect()->route('admin.teacher.index')->with('success', 'Thêm mới giáo viên thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.teacher.index')->with('error', 'Thêm mới giáo viên thất bại: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $teacher = Admin::findOrFail($id);
        return view('admin.content.teacher.edit', [
            'page' => 'manage-teacher',
            'teacher' => $teacher,
        ]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Admin::findOrFail($id);
        $credentials = $request->validate([
            // các rule
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($teacher->id),],
            'name' => ['required', 'max:255'],
        ],
            [
                // các thông báo lỗi
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'name.required' => 'Vui lòng nhập name',
                'name.max' => 'Tên không được vượt quá 255 ký tự',
            ]);
        try {
            $teacher->update([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
            ]);
            return redirect()->route('admin.teacher.index')->with('success', 'Cập nhật thông tin giáo viên thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.teacher.index')->with('error', 'Cập nhật thông tin giáo viên thất bại: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $teacher = Admin::find($request->input('del-object-id'));
        try {
            $teacher->delete();
            return redirect()->route('admin.teacher.index')->with('success', 'Xóa giáo viên thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.teacher.index')->with('error', 'Xóa giáo viên thất bại: ' . $e->getMessage());
        }
    }


    public function resetPassword($id){

        // Find the user by ID
        $teacher = Admin::findOrFail($id);

        // Update the user's password to '123456789'
        $teacher->password = Hash::make('123456789');

        // Save the changes to the database
        $teacher->save();
        return redirect()->route('admin.teacher.index')->with('success', 'Đặt lại mật khẩu thành công!');
    }

    public function export(Request $request){
        return Excel::download(new UsersExport($request), 'Danh sách người dùng.xlsx');
    }
}
