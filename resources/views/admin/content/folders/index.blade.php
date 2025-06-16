@extends('admin.layouts.adminApp')
@section('title', 'Quản lý folders')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý folders</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <!-- Define route for delete action -->
    @php($routeDelete = route('admin.folder.destroy'))

    <div class="grid grid-cols-12 gap-6 mt-8">
        <div class="col-span-12 lg:col-span-4 2xl:col-span-4">
            <h2 class="intro-y text-lg font-medium mr-auto mt-2">
                Quản lý Folders
            </h2>
            <!-- BEGIN: Folder Tree -->
            <div class="intro-y box p-5 mt-6">
                <div class="mt-1">
                    <ul class="folder-tree">
                        @foreach ($folders as $folder)
                            @include('admin.components.folder_node_ui', ['folder' => $folder,  'depth' => 0, 'active_ids' => $active_ids ?? []])
                        @endforeach
                    </ul>
                </div>
                <div class="border-t border-slate-200 dark:border-darkmode-400 mt-4">
                    <button type="button"
                            class="flex items-center gap-2 px-3 py-2 mt-2 rounded-md add-subfolder-btn"
                            data-id="{{ null }}"
                            data-name="Thư mục gốc"
                            data-tw-toggle="modal"
                            data-tw-target="#add-folder-modal"
                    >
                        <i class="fa-solid fa-add"></i>Thêm folder mới
                    </button>

                </div>
            </div>
            <!-- END: Folder Tree -->
        </div>
        <div class="col-span-12 lg:col-span-8 2xl:col-span-8">
            <!-- BEGIN: Folder Detail -->
            <div class="intro-y flex justify-start items-center">
                <div class="flex justify-start items-center gap-1 text-md mt-4">
                    <a href="{{route('admin.folder.index')}}" class="font-normal ">Thư mục gốc/</a>
                    @foreach($paths as $path)
                        @if ($loop->last)
                            <span class="text-slate-500 font-normal"> {{$path->name}}</span>
                        @else
                            <a href="{{route('admin.folder.index')."?folder_id=".$path->id}}" class="font-normal hover:font-semibold">{{$path->name}}/</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- END: Folder Detail -->

            <!-- BEGIN: Directory & Files -->
            <div class="intro-y grid grid-cols-4 gap-3 sm:gap-6 mt-6">
                @foreach($subFolders as $subFolder)
                    <div class="file box rounded-md px-5 pt-8 pb-5 sm:px-5 relative zoom-in">
                        <div class="absolute left-0 top-0 mt-3 ml-3">
                            <input class="form-check-input border border-slate-500" type="checkbox">
                        </div>
                        <a href="{{route('admin.folder.index').'?folder_id='.$subFolder->id}}"  class="w-3/5 file__icon file__icon--directory mx-auto"></a>
                        <a href="{{route('admin.folder.index').'?folder_id='.$subFolder->id}}"   class="block font-medium mt-4 text-center truncate">{{$subFolder->name}}</a>
                        <div class="text-slate-500 text-xs text-center mt-0.5">{{count($subFolder->children)}} thư mục con</div>
                        <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content">
                                    <!-- Sửa tên folder -->
                                    <li>
                                        <button type="button"
                                                class="dropdown-item edit-folder-btn"
                                                data-id="{{ $subFolder->id }}"
                                                data-name="{{ $subFolder->name }}"
                                                data-tw-toggle="modal"
                                                data-tw-target="#edit-folder-modal"
                                        >
                                            <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Sửa tên folder
                                        </button>

                                    </li>

                                    <!-- Copy folder -->
                                    <li>
                                        <a class="dropdown-item copy-folder-btn"
                                           href="{{route('admin.folder.copy', ['id' => $folder->id])}}"
                                        >
                                            <i class="fa fa-copy mr-2"></i>
                                            Copy folder
                                        </a>

                                    </li>

                                    <!-- Xoá folder -->
                                    <li>
                                        <button type="button" data-tw-toggle="modal"
                                                data-tw-target="#delete-object-confirm-form"
                                                class="dropdown-item"
                                                onclick='openConfirmDeleteObjectForm("{{ $subFolder->name}}", {{ $subFolder->id }})'
                                        >
                                            <i class="fa-solid fa-trash-can mr-2" ></i>
                                            Xóa folder
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- END: Directory & Files -->

            <!-- BEGIN: Pagination -->
            <!-- END: Pagination -->
        </div>
    </div>

@endsection
@section('custom-modal')
    <!-- BEGIN: Modal Add Folder -->
    <div id="add-folder-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Thêm mới folder
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="{{route('admin.folder.store')}}" method="POST">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-parent-folder-name" class="form-label">Thư mục cha</label>
                            <input id="modal-parent-folder-name" type="text" class="form-control" name="parent_name" readonly>
                        </div>

                        <div class="col-span-12 sm:col-span-12 hidden">
                            <label for="modal-parent-folder-id" class="form-label">ID thư mục cha</label>
                            <input id="modal-parent-folder-id" type="text" class="form-control" name="parent_id" readonly>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Tên thư mục thêm mới</label>
                            <input id="modal-form-2" type="text" name="name" class="form-control" placeholder="Nhập tên thư mục mới" required>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <!-- END: Modal Add Folder -->

    <!-- BEGIN: Modal Edit Folder -->
    <div id="edit-folder-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Sửa tên folder
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <form action="{{route('admin.folder.update')}}" method="POST">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                        <div class="col-span-12 sm:col-span-12 ">
                            <label for="modal-folder-id" class="form-label">ID thư mục </label>
                            <input id="modal-folder-id" type="text" class="form-control" name="folder_id" readonly>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-folder-name" class="form-label">Tên thư mục</label>
                            <input id="modal-folder-name" type="text" name="name" class="form-control" placeholder="Nhập tên thư mục mới" required>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <!-- END: Modal Edit Folder -->
@endsection
@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ẩn hiện các folder con khi nhấn +, - trong cây thư mục
            document.querySelectorAll('.toggle-button').forEach(button => {
                button.addEventListener('click', () => {
                    const childrenList = button.closest('li').querySelector('ul');
                    const icon = button.querySelector('i');

                    if (childrenList) {
                        childrenList.classList.toggle('hidden');
                        icon.classList.toggle('fa-plus');
                        icon.classList.toggle('fa-minus');
                    }
                });
            });

            // Thêm thông tin thư mục cha vào modal khi nhấn nút thêm folder
            document.querySelectorAll('.add-subfolder-btn').forEach(button => {
                button.addEventListener('click', () => {
                    // Đưa thông tin vào modal
                    document.getElementById('modal-parent-folder-name').value = button.getAttribute('data-name');
                    document.getElementById('modal-parent-folder-id').value = button.getAttribute('data-id');
                });
            });

            // Thêm thông tin thư mục vào modal khi nhấn nút edit folder
            document.querySelectorAll('.edit-folder-btn').forEach(button => {
                button.addEventListener('click', () => {
                    // Đưa thông tin vào modal
                    document.getElementById('modal-folder-name').value = button.getAttribute('data-name');
                    document.getElementById('modal-folder-id').value = button.getAttribute('data-id');
                });
            });

            // Xử lý sự kiện khi nhấn nút copy folder nhiều lần trong thời gian ngắn
            document.querySelectorAll('.copy-folder-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    // Ngăn bấm nhiều lần
                    if (this.classList.contains('disabled')) {
                        e.preventDefault(); // Chặn nếu đã disabled
                        return false;
                    }

                    this.classList.add('disabled');
                    this.style.pointerEvents = 'none';
                    this.style.opacity = 0.5;

                    // Optional: cho phép lại sau vài giây nếu không redirect
                    setTimeout(() => {
                        this.classList.remove('disabled');
                        this.style.pointerEvents = '';
                        this.style.opacity = '';
                    }, 5000);
                });
            });
        });
    </script>
@endsection
