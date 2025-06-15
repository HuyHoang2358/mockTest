<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Folder;
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

            }
        } else {
            $data["selectedFolder"] = null;
            $data["subFolders"] = Folder::whereNull('parent_id')->get();
        }
        $data['paths'] = array_reverse($data['paths']);
        return view('admin.content.folders.index', $data);
    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
       /* echo "<pre>";
        print_r($request->all());
        echo "</pre>";
        exit();*/
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        $folder = Folder::create($request->only('name', 'parent_id'));

        return redirect()->route('admin.folder.index', ["folder_id"=> $folder->id])->with('success', 'Thêm mới thư mục thành công.');
    }
}
