<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Folder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    public function index(Request $request) :View
    {
        // Lấy tất cả các thư mục gốc (không có parent_id) và các thư mục con của chúng
        $data["folders"] = Folder::with('childrenRecursive')->whereNull('parent_id')->get();


        $data['selectedFolder'] = null;
        $data['subFolders'] = collect();
        $data['active_ids'] = [];
        $data['paths'] = [];
        $data['exams'] = [];
        // Nếu có folder_id được chọn
        if ($request->has('folder_id')) {
            $selected = Folder::find($request->folder_id);
            if ($selected) {
                // Gán selectedFolder và các con
                $data['selectedFolder'] = $selected;
                $data['subFolders'] = $selected->children()->get();

                // Truy ngược lên để lấy tất cả cha -> mảng active_ids
                $activeIds = [$selected->id];
                $current = $selected;
                $data['paths'][] = $selected;
                while ($current->parent_id) {
                    $activeIds[] = $current->parent_id;

                    $current = $current->parent;
                    $data['paths'][] = $current;
                }

                $data['active_ids'] = $activeIds;

                // Lấy tất cả các exams của folder
                if (count( $data['subFolders']) == 0){
                    $data['exams'] = Exam::where('folder_id', $selected->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                }

            }
        } else {
            $data["selectedFolder"] = null;
            $data["subFolders"] = Folder::whereNull('parent_id')->get();

        }
        $data['paths'] = array_reverse($data['paths']);
        $data['page'] = 'manage-folder';
        return view('admin.content.folders.index', $data);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        $folder = Folder::create($request->only('name', 'parent_id'));

        return redirect()->route('admin.folder.index', ["folder_id"=> $folder->id])->with('success', 'Thêm mới thư mục "'.$folder->name.'" thành công.');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder_id' => 'required|exists:folders,id',
        ]);

        $folder = Folder::find($request->input('folder_id'));
        if (!$folder) {
            return redirect()->route('admin.folder.index')->with('error', 'Thư mục không tồn tại.');
        }

        $folder->name = $request->input('name');
        $folder->save();

        return redirect()->route('admin.folder.index', ["folder_id"=> $folder->id])->with('success', 'Cập nhật thư mục "'.$folder->name.'" thành công.');
    }

    public function cloneFolderWithChildren(Folder $folder, ?int $newParentId = null): Folder
    {
        // Bước 1: Sao chép folder hiện tại
        $newFolder = $folder->replicate();
        $newFolder->name = $newFolder->name . ' - Copy';
        $newFolder->parent_id = $newParentId;
        $newFolder->save();

        // Bước 2: Duyệt và sao chép từng thư mục con
        foreach ($folder->children as $child) {
            $this->cloneFolderWithChildren($child, $newFolder->id);
        }

        return $newFolder;
    }

    public function copy(Request $request, $id): RedirectResponse
    {
        $folder = Folder::find($id);
        if (!$folder) {
            return redirect()->route('admin.folder.index')->with('error', 'Thư mục không tồn tại.');
        }
        $folder->load('children');
        $this->cloneFolderWithChildren($folder);

        return redirect()->route('admin.folder.index')->with('success', 'Đã sao chép toàn bộ thư mục và các thư mục con.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $folder = Folder::find($request->input('del-object-id'));
        try {
            $folder->delete();

            // Tìm folder cha
            $parentFolder = $folder->parent;

            // Nếu có folder cha, chuyển hướng về folder cha
            if ($parentFolder) return redirect()->route('admin.folder.index', ['folder_id' => $parentFolder->id])
                ->with('success', 'Xóa thư mục "'.$folder->name.'" thành công!');
            // Nếu không có folder cha, chuyển hướng về danh sách thư mục gốc
            return redirect()->route('admin.folder.index')->with('success', 'Xóa thư mục "'.$folder->name.'" thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.folder.index')->with('error', 'Xóa thư mục thất bại: ' . $e->getMessage());
        }
    }

    public function listExam(Request $request): View
    {
        $exams = Exam::orderBy('created_at', 'desc')->paginate(10);
        $exams->load('folder');
        $data['exams'] = $exams;
        $data['page'] = 'manage-exam';
        return view('admin.content.folders.listExam', $data);
    }
}
