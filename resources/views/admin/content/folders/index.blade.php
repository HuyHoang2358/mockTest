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
                            <a class="dropdown-toggle w-5 h-5 block" aria-expanded="false" data-tw-toggle="dropdown">
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

            <!-- BEGIN: Add exam form -->
            <div  id="exam-add-form" class="leading-relaxed">
                <div class="intro-y box ">
                    <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto text-primary">
                            Thêm mới bài tập/đề thi
                        </h2>
                    </div>
                    <div class="accordion accordion-boxed p-5">
                        <form action="{{route('admin.question-type.store')}}" method="POST">
                            @csrf
                            <!-- Tên folder -->
                            <div>
                                <label for="exam-folder-id-input" class="form-label">Tên Folder </label>
                                <input id="exam-folder-id-input" type="text" class="form-control" placeholder="Nhập id folder" name="exam_folder_id" required>
                            </div>

                            <!-- Tên bài tập, bài thi -->
                            <div class="mt-2">
                                <label for="exam-name-input" class="form-label">Tên bài tập/đề thi</label>
                                <input id="exam-name-input" type="text" class="form-control" placeholder="Nhập tên bài thi" name="exam_name" required>
                            </div>

                            <!-- Cấu hình thời gian thi -->
                            <div class="mt-2">
                                <!-- Title -->
                                <div class="flex justify-between items-center">
                                    <p class="form-label">Thông tin cấu hình thời gian</p>
                                </div>
                                <div id="exam-time-container">
                                    <div class="config-item border p-3 rounded-lg">
                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- Tổng thời gian thi -->
                                            <div class="col-span-1">
                                                <label for="exam-total-time-input" class="form-label">Tổng thời gian</label>
                                                <input id="exam-total-time-input" type="number" class="form-control" placeholder="Nhập tổng thời gian (phút)" name="exam_total_time" required>
                                            </div>

                                            <!-- Thời gian bắt đầu mở thi -->
                                            <div class="col-span-1">
                                                <label for="exam-start-time-input" class="form-label">Thời gian bắt đầu mở</label>
                                                <input id="exam-start-time-input" type="datetime-local" class="form-control" name="exam_start_time" required>
                                            </div>

                                            <!-- Thời gian đóng bài thi -->
                                            <div class="col-span-1">
                                                <label for="exam-end-time-input" class="form-label">Thời gian đóng</label>
                                                <input id="exam-end-time-input" type="datetime-local" class="form-control" name="exam_end_time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>




                            <!-- Mật khẩu bài thi -->
                            <!-- Giá tiền -->
                            <!-- Phải thanh toán -->
                            <!-- Số lần thi tối đa  -->

                            <!-- Tên loại câu hỏi -->
                            <div>
                                <label for="question-type-name-input" class="form-label">Tên loại câu hỏi</label>
                                <input id="question-type-name-input" type="text" class="form-control" placeholder="Nhập tên loại câu hỏi" name="question_type_name" required>
                            </div>

                            <!-- Mô tả loại câu hỏi -->
                            <div class="mt-2">
                                <label for="question-type-description-input" class="form-label">Mô tả loại câu hỏi</label>
                                <textarea id="question-type-description-input" type="text" class="form-control"  rows=2 placeholder="Nhập tên loại câu hỏi" name="question_type_description"></textarea>
                            </div>

                            <!-- Cấu hình -->
                            <div class="mt-2">
                                <!-- Title -->
                                <div class="flex justify-between items-center">
                                    <p class="form-label">Thông tin cấu hình</p>
                                    <button id="add-config-btn" class="text-white px-2 py-1 text-xs rounded bg-primary tooltip"
                                            type="button"
                                            data-theme="light"
                                            title="Thêm mới cấu hình">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                <div id="config-container" class="mt-2">
                                    <!-- Cấu hình 1 -->
                                    <div class="config-item border p-3 rounded-lg my-3 relative">
                                        <!-- Tên cấu hình -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="col-span-1">
                                                <label for="question_type_config_key_1" class="form-label">Tên cấu hình</label>
                                                <input id="question_type_config_key_1" type="text" class="form-control" placeholder="Nhập tên loại câu hỏi" name="question_type_config_key[]" required>
                                            </div>

                                            <div class="col-span-1">
                                                <label class="form-label">Bắt buộc</label>
                                                <div class="flex flex-col sm:flex-row mt-2 gap-4">
                                                    <div class="form-check mr-2">
                                                        <input id="question_type_config_is_require_1_1" class="form-check-input" type="radio" name="question_type_config_is_require[]" value="1" checked>
                                                        <label class="form-check-label" for="question_type_config_is_require_1_1">Bắt buộc</label>
                                                    </div>
                                                    <div class="form-check mr-2 mt-2 sm:mt-0">
                                                        <input id="question_type_config_is_require_1_2" class="form-check-input" type="radio" name="question_type_config_is_require[]" value="0">
                                                        <label class="form-check-label" for="question_type_config_is_require_1_2">Không bắt buộc</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mô tả cấu hình -->
                                        <div class="mt-2">
                                            <label for="question_type_config_description_1" class="form-label">Mô tả thông tin cấu hình</label>
                                            <textarea id="question_type_config_description_1" type="text" class="form-control"  rows=2 placeholder="Nhập tên loại câu hỏi" name="question_type_config_description[]"></textarea>
                                        </div>

                                        <!-- Giá trị cấu hình -->
                                        <div class="mt-2">
                                            <label for="question_type_config_value_1" class="form-label">Giá trị cấu hình <span class="text-gray-400 text-xs italic ml-4">Các giá trị cách nhau bởi dấu ",". Bỏ trống nếu giá trị đó người dùng tự điền</span></label>
                                            <input id="question_type_config_value_1" type="text" class="form-control" placeholder="Nhập giá trị của cấu hình" name="question_type_config_value[]">
                                        </div>
                                        <button class="absolute top-0 right-0 mt-[-10px] mr-[-10px] bg-white border border-red-500 rounded-full w-6 h-6 text-xs text-red-500 tooltip delete-config"
                                                data-theme="light"
                                                title="Xóa cấu hình này"
                                                type="button"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>

                                    <!-- Cấu hình 2 -->
                                </div>


                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                                <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Hủy</button>
                                <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Add exam form -->
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
