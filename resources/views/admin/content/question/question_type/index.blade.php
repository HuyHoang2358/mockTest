@extends('admin.layouts.adminApp')
@section('title', 'Quản lý loại câu hỏi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý loại câu hỏi</a></li>
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
    <!-- Define route for delete action -->
    @php
        $routeDelete = route('admin.question-type.destroy');
    @endphp


    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Danh mục các loại câu hỏi
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: FAQ Menu -->
        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
            <div class="box mt-5">
                <div class="px-4 pb-3 pt-5 question-type-list" role="tablist">
                    @foreach($question_types as $question_type)
                        <div role="presentation" >
                            <button type="button" class="w-full flex justify-start items-center px-4 py-2 mt-1 rounded {{$loop->index == 0 ? 'active' :''}}" data-tw-toggle="pill" data-tw-target="#question-type-detail-{{$question_type->id}}" role="tab" aria-selected="{{$loop->index == 0 ? 'true' : 'false'}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="activity" class="lucide lucide-activity w-4 h-4 mr-2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                <span class="truncate">{{$question_type->name}}</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="px-4 py-3 border-t border-slate-200/60 dark:border-darkmode-400" role="tablist">
                    <button type="button" class="flex items-center px-4 py-2" data-tw-toggle="pill" data-tw-target="#question-type-add-form" role="tab">
                        <i class="fa-solid fa-add mr-2"></i>
                        <span class="flex-1 truncate">Thêm mới loại câu hỏi</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- END: FAQ Menu -->
        <!-- BEGIN: FAQ Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9 tab-content">
            @foreach($question_types as $question_type)
                <div  id="question-type-detail-{{$question_type->id}}" class="tab-pane leading-relaxed {{$loop->index == 0 ? 'active' :''}}" role="tabpanel">
                    <div class="intro-y box lg:mt-5">
                        <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <div class="flex justify-between items-center">
                                <h2 class="font-medium text-base mr-auto text-primary">
                                   Loại: {{$question_type->name}}
                                </h2>
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{route('admin.question-type.edit', $question_type->id)}}">
                                        <button type="button" class="text-green-500 hover:text-green-800 text-md tooltip"
                                                data-id="92"
                                                data-theme="light"
                                                title="Chỉnh sửa thông tin loại câu hỏi này">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </a>
                                    <button type="button"
                                            data-tw-toggle="modal" data-tw-target="#delete-object-confirm-form"
                                            class="text-red-500 hover:text-red-800 text-xs tooltip"
                                            data-theme="light"
                                            title="Xóa loại câu hỏi này"
                                            onclick='openConfirmDeleteObjectForm("{{ $question_type->name}}", {{ $question_type->id }})'
                                    >
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="accordion accordion-boxed p-5">
                            <div class="flex justify-between items-center">
                                <h3 class="font-semibold"> Thông số cấu hình</h3>

                            </div>

                            @foreach($question_type->configKeys as $configKey)
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-{{$configKey->id}}" class="accordion-header">
                                        <div class="flex justify-between items-center">
                                            <button type="button" class="accordion-button collapsed"> {{$configKey->key}} </button>
                                            <div class="flex justify-end items-center gap-2">
                                                @php $keyValues = json_decode($configKey->value, true); @endphp
                                                @if(is_array($keyValues) && count($keyValues) > 0)
                                                    @foreach($keyValues as $keyValue)
                                                        @if(is_bool($keyValue))
                                                            @php $keyValue = $keyValue ? 'True' : 'False'; @endphp
                                                        @endif
                                                            <button type="button" class="px-4 py-1 rounded-lg w-20" style="border:1px solid blue"> {{$keyValue}} </button>
                                                    @endforeach
                                                @else
                                                    <button type="button" class="p-2 rounded-lg w-20" style="border:1px solid blue"> Input </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div id="faq-accordion-collapse-{{$configKey->id}}" class="py-2">
                                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">{{$configKey->description}}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- BEGIN: Add Question Type Form -->
            <div  id="question-type-add-form"  class="tab-pane leading-relaxed" role="tabpanel">
                <div class="intro-y box lg:mt-5">
                    <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto text-primary">
                            Thêm mới loại câu hỏi
                        </h2>
                    </div>
                    <div class="accordion accordion-boxed p-5">
                        <form action="{{route('admin.question-type.store')}}" method="POST">
                            @csrf
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

            <!-- END: Add Question Type Form -->
        </div>
        <!-- END: FAQ Content -->
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
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('config-container');
        const template = document.getElementById('config-template');
        const addBtn = document.getElementById('add-config-btn');

        // Thêm mới cấu hình
        addBtn.addEventListener('click', function () {
            console.log('Thêm mới cấu hình');
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
    });
</script>
@endsection
