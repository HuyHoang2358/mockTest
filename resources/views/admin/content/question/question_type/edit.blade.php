@extends('admin.layouts.adminApp')
@section('title', 'Sửa thông tin loại câu hỏi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.question-type.index')}}">Quản lý loại câu hỏi</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Sửa thông tin loại câu hỏi</a></li>
        </ol>
    </nav>
@endsection
@section('head')
    <style>
        .question-type-list button.active {
            background-color: #e0f7fa;
            color: #00796b;
        }
        .question-type-list button:hover {
            background-color: #b2ebf2;
            color: #004d40;
        }
    </style>
@endsection

@section('content')

    <div class="grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9 tab-content">
            <!-- BEGIN: Edit Question Type Form -->
            <div  id="question-type-add-form"  class="leading-relaxed">
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto text-primary">
                            Chỉnh sửa thông tin loại câu hỏi
                        </h2>
                    </div>
                    <div class="accordion accordion-boxed p-5">
                        <form action="{{route('admin.question-type.update', $item->id)}}" method="POST">
                            @csrf
                            <!-- Tên loại câu hỏi -->
                            <div>
                                <label for="question-type-name-input" class="form-label">Tên loại câu hỏi</label>
                                <input id="question-type-name-input" type="text" class="form-control" placeholder="Nhập tên loại câu hỏi" name="question_type_name" value="{{$item->name}}"  required>
                            </div>

                            <!-- Mô tả loại câu hỏi -->
                            <div class="mt-2">
                                <label for="question-type-description-input" class="form-label">Mô tả loại câu hỏi</label>
                                <textarea id="question-type-description-input" type="text" class="form-control"  rows=2 placeholder="Nhập tên loại câu hỏi" name="question_type_description">{{$item->description}}</textarea>
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
                                    <!-- Cấu hình 2 -->
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end flex-col md:flex-row gap-2 mt-5">
                                <a href="{{route('admin.question-type.index')}}" >
                                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Hủy</button>
                                </a>
                                <button type="submit" id="btn-submit-form" class="btn py-3 btn-primary w-full md:w-52">Lưu thông tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Edit Question Type Form -->
        </div>
    </div>

    <!-- Template ẩn -->
    <div id="config-template" class="config-item border p-3 rounded-lg my-3 relative hidden">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1">
                <label class="form-label">Tên cấu hình</label>
                <input type="text" class="form-control" placeholder="Nhập tên loại câu hỏi" name="question_type_config_key[]" required>
            </div>

            <div class="col-span-1">
                <label class="form-label">Bắt buộc</label>
                <div class="flex flex-col sm:flex-row mt-2 gap-4">
                    <div class="form-check mr-2">
                        <input class="form-check-input" type="radio" name="question_type_config_is_require_tmp" value="1" checked>
                        <label class="form-check-label">Bắt buộc</label>
                    </div>
                    <div class="form-check mr-2 mt-2 sm:mt-0">
                        <input class="form-check-input" type="radio" name="question_type_config_is_require_tmp" value="0">
                        <label class="form-check-label">Không bắt buộc</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <label class="form-label">Mô tả thông tin cấu hình</label>
            <textarea class="form-control" rows=2 placeholder="Nhập tên loại câu hỏi" name="question_type_config_description[]"></textarea>
        </div>

        <div class="mt-2">
            <label class="form-label">Giá trị cấu hình <span class="text-gray-400 text-xs italic ml-4">Các giá trị cách nhau bởi dấu ",". Bỏ trống nếu giá trị đó người dùng tự điền</span></label>
            <input type="text" class="form-control" placeholder="Nhập giá trị của cấu hình" name="question_type_config_value[]">
        </div>

        <button type="button" class="absolute top-0 right-0 mt-[-10px] mr-[-10px] bg-white border border-red-500 rounded-full w-6 h-6 text-xs text-red-500 delete-config tooltip"
                data-theme="light"
                title="Xóa cấu hình này"
        >
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>
@endsection

@section('customJs')
<script>
    const configKeys = @json($item->configKeys);
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('config-container');
        const template = document.getElementById('config-template');
        const addBtn = document.getElementById('add-config-btn');

        // Thêm mới cấu hình
        addBtn.addEventListener('click', function () {
            const clone = template.cloneNode(true);
            clone.classList.remove('hidden');
            clone.removeAttribute('id');

            // Sửa lại name cho radio group để không bị trùng (quan trọng)
            const radios = clone.querySelectorAll('input[type=radio]');
            const index = container.children.length;
            radios.forEach(r => {
                r.name = `question_type_config_is_require[${index}]`;
            });

            container.appendChild(clone);
        });

        // Xóa cấu hình
        container.addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.delete-config');
            if (deleteBtn) {
                const configBlock = deleteBtn.closest('.config-item');
                if (configBlock) {
                    configBlock.remove();
                }
            }
        });

        // Tải cấu hình từ biến configKeys
        configKeys.forEach(config => {
            const clone = template.cloneNode(true);
            clone.classList.remove('hidden');
            clone.removeAttribute('id');

            // Điền dữ liệu vào các trường
            clone.querySelector('input[name="question_type_config_key[]"]').value = config.key;
            clone.querySelector('textarea[name="question_type_config_description[]"]').value = config.description;
            clone.querySelector('input[name="question_type_config_value[]"]').value = JSON.parse(config.value);

            // Xử lý radio button
            const radios = clone.querySelectorAll('input[type=radio]');
            radios.forEach(r => {
                r.checked = (r.value == config.is_required) ? true : false;
                r.name = `question_type_config_is_require[${container.children.length}]`;
            });

            container.appendChild(clone);
        });
    });
</script>
@endsection
