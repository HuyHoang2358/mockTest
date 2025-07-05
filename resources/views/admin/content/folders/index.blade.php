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
                            @include('admin.components.folder_node_ui', ['folder' => $folder,  'depth' => 0, 'active_ids' => $active_ids ?? [], 'onAddExam' => 'openAddExamForm'])
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
        <div class="col-span-12 lg:col-span-8 2xl:col-span-8 mt-4">
            <!-- BEGIN: Folder Detail -->
            <div class="intro-y flex justify-between items-center">
                <div class="flex justify-start items-center">
                    <div class="flex justify-start items-center gap-1 text-md">
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

                @if(request()->has('folder_id') && count($subFolders) == 0)
                    <button type="button"
                            class="flex items-center gap-2 btn-primary btn"
                            onclick="openAddExamForm({{ request()->get('folder_id') }})"
                            id="btn-add-exam"
                    >
                        <i class="fa-solid fa-add"></i>Thêm bài tập
                    </button>
                @endif
            </div>
            <!-- END: Folder Detail -->

            <!-- BEGIN: Directory & Files -->
            <div class="intro-y grid grid-cols-4 gap-3 sm:gap-6 mt-2" id="folder-file-detail">
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

                @foreach($exams as $exam)
                    <div class="file box rounded-md px-5 pt-8 pb-5 sm:px-5 relative zoom-in">
                        <a href="{{route('admin.exam.detail',$exam->id)}}" class="w-3/5 file__icon file__icon--file mx-auto">
                            <div class="file__icon__file-name">Exam</div>
                        </a>
                        <a href="{{route('admin.exam.detail', $exam->id)}}"   class="block font-medium mt-4 text-center truncate">{{$exam->name}}</a>
                        <div class="text-slate-500 text-xs text-center mt-0.5">{{'1'}} thư mục con</div>
                        <!-- Action for exam -->
                        <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                            <a class="dropdown-toggle w-5 h-5 block" aria-expanded="false" data-tw-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </a>
                            <div class="dropdown-menu w-48">
                                <ul class="dropdown-content">
                                    <!-- Sửa tên folder -->
                                    <li>
                                        <button type="button"
                                                class="dropdown-item edit-folder-btn"
                                                onclick="openEditExamForm({{ $exam->id }})"
                                        >
                                            <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Chỉnh sửa thông tin
                                        </button>

                                    </li>

                                    <!-- Xoá folder -->
                                    <li>
                                        <button type="button"
                                                data-tw-toggle="modal"
                                                data-tw-target="#delete-exam-confirm-form"
                                                class="dropdown-item"
                                                onclick='openConfirmDeleteExamForm("{{ $exam->name}}", {{ $exam->id }})'
                                        >
                                            <i class="fa-solid fa-trash-can mr-2" ></i>
                                            Xóa bài tập
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
            <div id="exam-add-form" class="leading-relaxed hidden mt-6">
                <div class="intro-y box ">
                    <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto text-primary">
                            Thêm mới bài tập/đề thi
                        </h2>
                    </div>
                    <div class="accordion accordion-boxed p-5">
                        <form action="{{route('admin.exam.store')}}" method="POST">
                            @csrf
                            <!-- Tên folder -->
                            <div class="hidden">
                                <label for="exam-folder-id-input" class="form-label">Tên Folder </label>
                                <input id="exam-folder-id-input" type="text" class="form-control" placeholder="Nhập id folder" name="exam_folder_id" required>
                            </div>

                            <!-- Tên bài tập, bài thi -->
                            <div class="mt-4">
                                <label for="exam-name-input" class="form-label">Tên bài tập/đề thi <span class="text-red-500">*</span></label>
                                <input id="exam-name-input" type="text" class="form-control" placeholder="Nhập tên bài thi" name="exam_name" required>
                            </div>

                            <!-- Cấu hình thời gian thi -->
                            <div class="mt-4">
                                <!-- Title -->
                                <div class="flex justify-between items-center">
                                    <p class="form-label">Thông tin cấu hình thời gian</p>
                                </div>

                                <div >
                                    <div class="config-item border p-3 rounded-lg">
                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- Tổng thời gian thi -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-total-time-input">Tổng thời gian</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Nếu để trống hệ thống sẽ tự cộng tổng các bài con"><i class="fa-regular fa-circle-question"></i></button>
                                                </div>
                                                <input id="exam-total-time-input" type="number" class="form-control" placeholder="Nhập tổng thời gian (phút)" name="exam_total_time">
                                            </div>

                                            <!-- Thời gian bắt đầu mở thi -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-start-time-input">Thời gian bắt đầu mở</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Thời gian bắt đầu có thể truy cập vào đề thi, bài tập"><i class="fa-regular fa-circle-question"></i></button>
                                                </div>

                                                <input id="exam-start-time-input" type="datetime-local" class="form-control" name="exam_start_time">
                                            </div>

                                            <!-- Thời gian đóng bài thi -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-end-time-input">Thời gian đóng</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Thời gian cuối cùng có thể truy cập vào đề thi, bài tập"><i class="fa-regular fa-circle-question"></i></button>
                                                </div>
                                                <input id="exam-end-time-input" type="datetime-local" class="form-control" name="exam_end_time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mật khẩu bài thi vs Giá tiền -->
                            <div class="mt-4">
                                <!-- Title -->
                                <div class="flex justify-between items-center">
                                    <p class="form-label">Cấu hình nâng cao</p>
                                </div>

                                <div >
                                    <div class="config-item border p-3 rounded-lg">
                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- Mật khẩu bài thi -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-password-input">Mật khẩu bài thi</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Mật khẩu bài thi có 8 ký tự. Bỏ trống nếu muốn không xác thực"><i class="fa-regular fa-circle-question"></i></button>
                                                </div><input id="exam-password-input" type="text" class="form-control" placeholder="Nhập mật khẩu cho bài thi" name="exam_password" maxlength="8" minlength="8" value="">
                                            </div>

                                            <!-- Giá tiền -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-price-input" >Giá tiền bài thi</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Để 0 nếu miễn phí."><i class="fa-regular fa-circle-question"></i></button>
                                                </div>

                                                <input id="exam-price-input" type="number" class="form-control" placeholder="Nhập giá tiền cho bài thi" name="exam_price" value="0"  min="0" required>
                                            </div>


                                            <!-- Giá tiền -->
                                            <div class="col-span-1">
                                                <div class="flex justify-start items-center gap-2 form-label">
                                                    <label for="exam-try-todo-input" >Số lần thi tối đa</label>
                                                    <button type="button" class="tooltip" data-theme="light" title="Số lần tối đa một học sinh có thể thi"><i class="fa-regular fa-circle-question"></i></button>
                                                </div>

                                                <input id="exam-try-todo-input" type="number" class="form-control" placeholder="Nhập số lần thi tối đa" name="exam_number_of_todo" value="1" min="1" max="1000" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                                <button type="button" onclick="cancelAddExamForm()"
                                        class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52"
                                >Hủy</button>
                                <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Add exam form -->


            <!-- BEGIN: Edit exam form -->
            @foreach($exams as $exam)
                <div id="exam-{{$exam->id}}-edit-form" class="leading-relaxed hidden mt-6">
                    <div class="intro-y box ">
                        <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto text-primary">
                                Chỉnh sửa thông tin bài tập/đề thi: {{$exam->name}}
                            </h2>
                        </div>
                        <div class="accordion accordion-boxed p-5">
                            <form action="{{route('admin.exam.update', $exam->id)}}" method="POST">
                                @csrf
                                <!-- Tên folder -->
                                <div class="hidden">
                                    <label for="exam-folder-id-input" class="form-label">Tên Folder </label>
                                    <input id="exam-folder-id-input" type="text" class="form-control" placeholder="Nhập id folder" name="exam_folder_id" value="{{$exam->folder_id}}" required>
                                </div>

                                <!-- Tên bài tập, bài thi -->
                                <div class="mt-4">
                                    <label for="exam-name-input" class="form-label">Tên bài tập/đề thi <span class="text-red-500">*</span></label>
                                    <input id="exam-name-input" type="text" class="form-control" placeholder="Nhập tên bài thi" name="exam_name" value="{{$exam->name}}" required>
                                </div>

                                <!-- Cấu hình thời gian thi -->
                                <div class="mt-4">
                                    <!-- Title -->
                                    <div class="flex justify-between items-center">
                                        <p class="form-label">Thông tin cấu hình thời gian</p>
                                    </div>

                                    <div >
                                        <div class="config-item border p-3 rounded-lg">
                                            <div class="grid grid-cols-3 gap-4">
                                                <!-- Tổng thời gian thi -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-total-time-input">Tổng thời gian</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Nếu để trống hệ thống sẽ tự cộng tổng các bài con"><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>
                                                    <input id="exam-total-time-input" type="number" class="form-control" placeholder="Nhập tổng thời gian (phút)" name="exam_total_time" value="{{$exam->time}}">
                                                </div>

                                                <!-- Thời gian bắt đầu mở thi -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-start-time-input">Thời gian bắt đầu mở</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Thời gian bắt đầu có thể truy cập vào đề thi, bài tập"><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>

                                                    <input id="exam-start-time-input" type="datetime-local" class="form-control" name="exam_start_time" value="{{$exam->start_time}}">
                                                </div>

                                                <!-- Thời gian đóng bài thi -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-end-time-input">Thời gian đóng</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Thời gian cuối cùng có thể truy cập vào đề thi, bài tập"><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>
                                                    <input id="exam-end-time-input" type="datetime-local" class="form-control" name="exam_end_time" value="{{$exam->end_time}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mật khẩu bài thi vs Giá tiền -->
                                <div class="mt-4">
                                    <!-- Title -->
                                    <div class="flex justify-between items-center">
                                        <p class="form-label">Cấu hình nâng cao</p>
                                    </div>

                                    <div >
                                        <div class="config-item border p-3 rounded-lg">
                                            <div class="grid grid-cols-3 gap-4">
                                                <!-- Mật khẩu bài thi -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-password-input">Mật khẩu bài thi</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Mật khẩu bài thi có 8 ký tự. Bỏ trống nếu muốn không xác thực"><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>
                                                    <input id="exam-password-input" type="text" class="form-control" placeholder="Nhập mật khẩu cho bài thi" name="exam_password" maxlength="8" minlength="8" value="{{$exam->password}}">
                                                </div>

                                                <!-- Giá tiền -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-price-input" >Giá tiền bài thi</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Để 0 nếu miễn phí."><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>

                                                    <input id="exam-price-input" type="number" class="form-control" placeholder="Nhập giá tiền cho bài thi" name="exam_price" min="0" value="{{$exam->price}}" required>
                                                </div>


                                                <!-- Số lần thi tối đa  -->
                                                <div class="col-span-1">
                                                    <div class="flex justify-start items-center gap-2 form-label">
                                                        <label for="exam-try-todo-input" >Số lần thi tối đa</label>
                                                        <button type="button" class="tooltip" data-theme="light" title="Số lần tối đa một học sinh có thể thi"><i class="fa-regular fa-circle-question"></i></button>
                                                    </div>

                                                    <input id="exam-try-todo-input" type="number" class="form-control" placeholder="Nhập số lần thi tối đa" name="exam_number_of_todo" value="{{$exam->number_of_todo}}" min="1" max="1000" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                                    <button type="button" onclick="cancelEditExamForm('{{$exam->id}}')"
                                            class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52"
                                    >Hủy</button>
                                    <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52">Cập nhật thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
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
    <!-- END: Modal Edit Folder -->\

    <!-- BEGIN: Modal delete exam -->
    <form method="POST" action="{{ route('admin.exam.destroy') }}" id="delete-exam-confirm-form" class="modal" tabindex="-1" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="px-5 pt-4 py-2  text-center flex justify-between items-center">
                        <p class="font-bold text-lg">Xác nhận xóa</p>
                        <button type="button" data-tw-dismiss="modal" class="p-2 ">
                            <i data-lucide="x-circle" class="w-6 h-6 text-danger"></i>
                        </button>
                    </div>
                    <div class="px-5 pb-4">
                        <div class="text-slate-500 mt-2">
                            <p class="font-semibold">Bạn có muốn xóa đề thi <span id="del-exam-name" class="font-bold text-red-600">xxxx</span>?</p>
                            <p class="text-gray-500 text-xs mt-1">Hành động này sẽ không thể hoàn tác.</p>
                        </div>
                        <input type="hidden" id="del-exam-id" name="del-object-id">
                    </div>
                    <div class="px-5 pb-8 text-center flex justify-end items-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Hủy</button>
                        <button type="submit" id="deleteExamButton" class="btn btn-danger">Xóa </button>
                        <button type="button" id="deletingExamButton" class="btn btn-danger hidden" disabled>
                            Deleting <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- END: Modal delete exam -->
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

        // Thêm mới bài thi
        function openAddExamForm(folderId) {
            document.getElementById('exam-add-form').classList.remove('hidden');

            document.getElementById('btn-add-exam').classList.add('hidden');
            document.getElementById('folder-file-detail').classList.add('hidden');
            // Cập nhật ID folder vào input
            document.getElementById('exam-folder-id-input').value = folderId;
        }

        // Hủy bỏ hiển thị form thêm bài thi
        function cancelAddExamForm() {
            document.getElementById('exam-add-form')?.classList.add('hidden');
            document.getElementById('btn-add-exam').classList.remove('hidden');
            document.getElementById('folder-file-detail').classList.remove('hidden');

            // Reset các input
            document.getElementById('exam-folder-id-input').value = '';
            document.getElementById('exam-name-input').value = '';
            document.getElementById('exam-total-time-input').value = '';
            document.getElementById('exam-start-time-input').value = '';
            document.getElementById('exam-end-time-input').value = '';
            document.getElementById('exam-password-input').value = '';
            document.getElementById('exam-price-input').value = '0';
            document.getElementById('exam-try-todo-input').value = '1';
        }

        // Xử lý sự kiện khi nhấn nút xóa exam
        function openConfirmDeleteExamForm(name, id) {
            document.getElementById('del-exam-name').textContent = name;
            document.getElementById('del-exam-id').value = id;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('deleteExamButton')?.addEventListener('click', function (e) {
                const btn = e.currentTarget;

                // Disable button
                btn.disabled = true;
                btn.classList.add('cursor-not-allowed', 'opacity-70', 'hidden');

                document.getElementById('deletingExamButton').classList.remove('hidden');
                // submit the form
                document.getElementById('delete-exam-confirm-form').submit();
            });
        });

        // Mở form chỉnh sửa bài thi
        function openEditExamForm(examId) {
            // Hiển thị form chỉnh sửa
            document.getElementById(`exam-${examId}-edit-form`).classList.remove('hidden');

            // Ẩn nút thêm bài thi
            document.getElementById('btn-add-exam').classList.add('hidden');
            document.getElementById('folder-file-detail').classList.add('hidden');
        }
        function cancelEditExamForm(examId) {
            document.getElementById(`exam-${examId}-edit-form`)?.classList.add('hidden');
            document.getElementById('btn-add-exam').classList.remove('hidden');
            document.getElementById('folder-file-detail').classList.remove('hidden');
        }
    </script>
@endsection
