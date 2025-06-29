@extends('admin.layouts.adminApp')
@section('title', 'Thông tin đề thi')
@section('breadcrumb')
    <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Trang Quản trị viên</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.folder.index').'?folder_id='.$exam->folder->id}}">{{$exam->folder->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$exam->name}}</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-4">
        <!-- Left side: Exam information -->
        <div class="col-span-9">
            <!-- Part tabs -->
            <div class="flex justify-between items-center">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($exam->parts as $part)
                            <li id="part-{{$part->id}}-tab" class="nav-item relative flex items-center " role="presentation">
                                <button class="nav-link w-full py-3 pr-8 text-left {{$loop->index == 0 ? 'active' : ''}}" type="button" role="tab"
                                        data-tw-toggle="pill" data-tw-target="#part-1"
                                        aria-controls="part-1" aria-selected="true"
                                >
                                    {{$part->name}}
                                </button>
                                {{--<span class="absolute right-1.5 top-0.5 text-gray-500 cursor-pointer hover:text-red-500 text-sm"
                                      onclick="removePart('{{$part->id}}')">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>--}}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="">
                    <button id="add-part-btn" class="btn btn-primary">
                        <i class="fa-solid fa-plus mr-2"></i> Part
                    </button>
                </div>
            </div>

            <!-- Part content -->
            <div class="tab-content border-l border-r border-b bg-white rounded-bl-lg rounded-br-lg">
                @foreach($exam->parts as $part)
                    <div id="part-{{$part->id}}" class="tab-pane leading-relaxed p-5 {{$loop->index == 0 ? 'active' : ''}}" role="tabpanel" aria-labelledby="part-{{$part->id}}-tab">
                        <div class="flex justify-between items-center">
                            <!-- Danh sách file đính kèm -->
                            <div class="mt-2 flex justify-start items-center gap-2">
                                <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                <span> Chưa có file đính kèm</span>
                            </div>

                            <!-- Điểm, thời gian, câu hỏi -->
                            <div class="flex justify-end items-center gap-3">
                                <!-- Tổng số câu hỏi của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của phần">
                                        <i class="fa-regular fa-circle-question"></i>
                                    </label>
                                    <input id="part-1-number-question-input" name="part_number_question[]" type="number" min=0 max= 100 class="w-16 form-control" disabled/>
                                </div>

                                <!-- Tổng số điểm của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </label>
                                    <input id="part-1-total-score-input" name="part_total_score[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                </div>


                                <!-- Tổng thời gian làm bài của phần -->
                                <div class="flex justify-start items-center gap-1">
                                    <label for="part-1-total-time-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                        <i class="fa-regular fa-clock"></i>
                                    </label>
                                    <input id="part-1-total-time-input" name="part_total_time[]" type="number" min=0 max= 100 class="w-20 form-control"/>
                                </div>

                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-4 part-content">
                            <input type="text" value="{{$part->content}}"
                                   class="flex-grow font-semibold border-none w-full text-2xl part-content-input py-1"
                                   placeholder="Nhập nội dung phần thi {{$part->name}}"
                                   readonly
                            />
                            <!-- edit button -->
                            <button class="btn btn-secondary tooltip" data-theme="light" title="Chỉnh sửa nội dung" type="button" onclick="toggleEdit(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <div class="part-content-detail">
                            <!-- Danh sách các nhóm câu hỏi -->
                            <div class="question-group ">
                                <div class="question-group-item mt-2 border-t-4 border-primary py-2" id="question-group-1">
                                    <!-- Title Question Group  -->
                                    <div class="flex justify-between items-center gap-4">
                                        <!-- Danh sách file đính kèm -->
                                        <div class="flex-grow">
                                            <input type="text" class="form-control text-md font-semibold text-primary" placeholder="Nhập tên nhóm câu hỏi" name="question_group_name[]" required>
                                        </div>

                                        <!-- Files, Điểm, thời gian, câu hỏi -->
                                        <div class="flex justify-end items-center gap-3">
                                            <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                                <i class="fa-solid fa-paperclip"></i>
                                            </button>

                                            <!-- Tổng số câu hỏi của nhóm câu hỏi -->
                                            <div class="flex justify-start items-center gap-1">
                                                <label for="question-group-1-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của nhóm" >
                                                    <i class="fa-regular fa-circle-question"></i>
                                                </label>
                                                <input id="question-group-1-number-question-input" name="question_group_number_question" type="number" min=0 max= 100 class="w-16 form-control" disabled/>
                                            </div>

                                            <!-- Tổng số điểm của nhóm câu hỏi -->
                                            <div class="flex justify-start items-center gap-1">
                                                <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                                    <i class="fa-regular fa-file-lines"></i>
                                                </label>
                                                <input id="part-1-total-score-input" name="question_group_score[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                            </div>


                                            <!-- Tổng thời gian làm bài của nhóm câu hỏi -->
                                            <div class="flex justify-start items-center gap-1">
                                                <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                                    <i class="fa-regular fa-clock"></i>
                                                </label>
                                                <input id="part-1-total-score-input" name="question_group_time[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content Question Group -->
                                    <div class="mt-2 pl-5 relative w-full  question-group-block">
                                        <textarea type="text" class="form-control content-editor" placeholder="Nội dung nhóm câu hỏi"
                                                  name="question_group_content[]"  id="question-group-editor">Nội dung nhóm câu hỏi</textarea>
                                        <!-- Vùng preview -->
                                        <div class="preview-content hidden border rounded p-3 mt-2"></div>

                                        <!-- Nút toggle -->
                                        <button type="button" class="z-[999] btn btn-secondary absolute top-2 right-2"
                                                onclick="toggleEditorPreview(this, 'question-group-editor')">
                                            <i class="fa-solid fa-eye"></i> Xem trước
                                        </button>
                                    </div>

                                    <!-- Handle Question List -->
                                    <div class="mt-2 pl-5">
                                        <div class="flex justify-between items-center gap-4">
                                            <h3 class="font-semibold text-primary text-md">Danh sách các câu hỏi</h3>
                                            <div class="flex justify-end items-center gap-2">
                                                <!-- Thêm mới câu hỏi -->
                                                <button type="button" class="btn btn-primary tooltip"
                                                        data-theme="light" title="Thêm câu hỏi"
                                                        data-tw-toggle="modal" data-tw-target="#add-question-modal"
                                                >
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <!-- Trích danh sách câu hỏi từ content -->
                                                <button type="button" class="btn btn-primary tooltip"
                                                        data-theme="light" title="Thêm câu hỏi từ vị trí trong đề"
                                                        onclick="handleExtractQuestions(this)"
                                                >
                                                    <i class="fa-solid fa-file-export"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-2 pl-5" id="question-list">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-start items-center gap-2 mt-8">
                                <button class="btn btn-primary" type="button" onclick="addQuestionGroup()">
                                    <i class="fa-solid fa-folder-plus mr-2"></i> Thêm nhóm câu hỏi
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Summary Exam -->
        <div class="col-span-3 box p-5">
            <div id="summary-exam" class="accordion accordion-boxed">
                <div class="accordion-item">
                    <div id="summary-exam-part-1-label" class="accordion-header">
                        <button class="accordion-button font-bold" type="button"
                                data-tw-toggle="collapse" data-tw-target="#summary-exam-part-1-collapse"
                                aria-expanded="true" aria-controls="summary-exam-part-1-collapse"
                        >
                            Part 1
                        </button>
                    </div>
                    <div id="summary-exam-part-1-collapse" class="accordion-collapse"
                         aria-labelledby="summary-exam-part-1-label" data-tw-parent="#summary-exam"
                    >
                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                            <button class="btn btn-primary question-item"> 1</button>
                            <button class="btn btn-primary">2</button>
                            <button class="btn btn-primary">3</button>
                            <button class="btn btn-primary">4</button>
                            <button class="btn btn-primary">5</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-modal')
    <!-- BEGIN: Modal Add Folder -->
    <div id="add-question-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Thêm mới câu hỏi
                    </h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <form id="add-question-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-control mt-2">
                            <label for="part-1-total-score-input" class="form-label">
                                Loại câu hỏi
                            </label>
                            <select class="form-select" name="question_type_id" onchange="handleQuestionTypeChange(this)">
                                @foreach($questionTypes as $questionType)
                                    <option value="{{$questionType->id}}">{{$questionType->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="config-question mt-2">
                            @foreach($questionTypes as $questionType)
                                <div class="modal-question-configs hidden" id="question-type-{{ $questionType->id }}">
                                    @foreach($questionType->configKeys as $config)
                                        <div class="mb-4">
                                            <label class="form-label font-semibold">
                                                {{ $config->description ?? $config->key }}
                                            </label>
                                            @php
                                                $isSelectable = false;
                                                if ($config->value !== null) {
                                                    $values = json_decode($config->value, true);
                                                    $isSelectable = is_array($values) && count($values) > 0;
                                                }
                                            @endphp
                                            @if($isSelectable)
                                                <select name="{{ $config->key }}" class="form-select mt-1">
                                                    @foreach($values as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text"
                                                       name="{{ $config->key }}"
                                                       class="form-control mt-1"
                                                />
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                        <button type="button" class="btn btn-primary" onclick="addQuestion()">Thêm mới</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <!-- END: Modal Add Folder -->
@endsection
@section('customJs')
    @include('admin.components.tinyInit')
    <script>
        let selectingQuestionType = '';
        let questionCounter = 0;
        let questionGroupIndex = 1;
        let isPreviewMode = false;

        function addQuestionGroup() {
            questionGroupIndex++;

            const groupHTML = `
                  <div class="question-group-item mt-2 border-t-4 border-primary py-2" id="question-group-${questionGroupIndex}">
                                <!-- Title Question Group  -->
                                <div class="flex justify-between items-center gap-4">
                                    <!-- Danh sách file đính kèm -->
                                    <div class="flex-grow">
                                        <input type="text" class="form-control text-md font-semibold text-primary" placeholder="Nhập tên nhóm câu hỏi" name="question_group_name[]" required>
                                    </div>

                                    <!-- Files, Điểm, thời gian, câu hỏi -->
                                    <div class="flex justify-end items-center gap-3">
                                        <button type="button" class="font-bold text-xl tooltip" data-theme="light" title="Đính kèm file">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </button>

                                        <!-- Tổng số câu hỏi của nhóm câu hỏi -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="question-group-${questionGroupIndex}-number-question-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng số câu hỏi của nhóm" >
                                                <i class="fa-regular fa-circle-question"></i>
                                            </label>
                                            <input id="question-group-${questionGroupIndex}-number-question-input" name="question_group_number_question" type="number" min=0 max= 100 class="w-16 form-control" disabled/>
                                        </div>

                                        <!-- Tổng số điểm của nhóm câu hỏi -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng điểm của phần (point)">
                                                <i class="fa-regular fa-file-lines"></i>
                                            </label>
                                            <input id="part-1-total-score-input" name="question_group_score[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                        </div>


                                        <!-- Tổng thời gian làm bài của nhóm câu hỏi -->
                                        <div class="flex justify-start items-center gap-1">
                                            <label for="part-1-total-score-input" class="font-bold text-xl tooltip" data-theme="light" title="Tổng thời gian làm bài (phút)">
                                                <i class="fa-regular fa-clock"></i>
                                            </label>
                                            <input id="part-1-total-score-input" name="question_group_time[]" type="number" min=0 max= 100 class="w-20 form-control" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Question Group -->
                                <div class="mt-2 pl-5 relative w-full  question-group-block">
                                    <textarea type="text" class="form-control content-editor" placeholder="Nội dung nhóm câu hỏi"
                                              name="question_group_content[]"  id="question-group-editor-${questionGroupIndex}">Nội dung nhóm câu hỏi</textarea>
                                    <!-- Vùng preview -->
                                    <div class="preview-content hidden border rounded p-3 mt-2"></div>

                                    <!-- Nút toggle -->
                                    <button type="button" class="z-[999] btn btn-secondary absolute top-2 right-2"
                                            onclick="toggleEditorPreview(this, 'question-group-editor-${questionGroupIndex}')">
                                        <i class="fa-solid fa-eye"></i> Xem trước
                                    </button>
                                </div>

                                <!-- Handle Question List -->
                                <div class="mt-2 pl-5">
                                    <div class="flex justify-between items-center gap-4">
                                        <h3 class="font-semibold text-primary text-md">Danh sách các câu hỏi</h3>
                                        <div class="flex justify-end items-center gap-2">
                                            <!-- Thêm mới câu hỏi -->
                                            <button type="button" class="btn btn-primary tooltip"
                                                    data-theme="light" title="Thêm câu hỏi"
                                                    data-tw-toggle="modal" data-tw-target="#add-question-modal"
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <!-- Trích danh sách câu hỏi từ content -->
                                            <button type="button" class="btn btn-primary tooltip"
                                                    data-theme="light" title="Thêm câu hỏi từ vị trí trong đề"
                                                    onclick="handleExtractQuestions(this)"
                                            >
                                                <i class="fa-solid fa-file-export"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-2 pl-5" id="question-list">
                                    </div>
                                </div>
                            </div>
            `;

            const container = document.querySelector('.question-group');
            const div = document.createElement('div');
            div.innerHTML = groupHTML;
            container.appendChild(div.firstElementChild);
        }

        function toggleQuestionVisibility(btn) {
            const checkIcon = btn.querySelector('.fa-square-check');
            const emptyIcon = btn.querySelector('.fa-square');

            const questionBlock = btn.closest('.question-item').querySelector('[id^="question-item-"]');
            if (!questionBlock) return;

            const isHidden = questionBlock.classList.toggle('hidden');

            btn.innerHTML = isHidden
                ? '<i class="fa-regular fa-square"></i>'
                : '<i class="fa-regular fa-square-check"></i>';

        }

        function toggleEditorPreview(button, editorId) {
            const editor = tinymce.get(editorId);
            if (!editor) return;

            const container = button.closest('.question-group-block');
            const previewDiv = container.querySelector('.preview-content');

            const isPreviewing = !previewDiv.classList.contains('hidden');

            if (!isPreviewing) {
                // 👉 Chuyển sang chế độ preview
                const html = editor.getContent();

                console.log(html);
                // Hiển thị nội dung đã soạn
                previewDiv.innerHTML = html;
                previewDiv.classList.remove('hidden');

                // Ẩn content editor
                editor.hide();
                // Ẩn textarea
                const textarea = container.querySelector('textarea.content-editor');
                if (textarea) {
                    textarea.classList.add('hidden');
                }

                // Đổi icon/nút
                button.innerHTML = `<i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa`;
            } else {
                // 👉 Quay lại chế độ chỉnh sửa
                previewDiv.classList.add('hidden');
                editor.show();

                button.innerHTML = `<i class="fa-solid fa-eye"></i> Xem trước`;
            }
        }

        function toggleEditQuestionGroupContent(button) {
            const container = button.closest('.relative');
            const wrapper = container.querySelector('.editor-wrapper');
            const displayDiv = container.querySelector('.rendered-content');
            const textarea = wrapper.querySelector('textarea');
            console.log("container", container, wrapper, displayDiv, textarea);


            if (!wrapper || !displayDiv) return;
            // Nếu đang ẩn textarea → hiện textarea và ẩn div
            if (wrapper.classList.contains('hidden')) {
                console.log("Showing textarea");
                // Set nội dung vào textarea
                wrapper.value = displayDiv.innerHTML.trim();

                // Hiện textarea + khởi tạo TinyMCE nếu chưa
                wrapper.classList.remove('hidden');
                displayDiv.classList.add('hidden');

            } else{
                console.log("Hiding textarea");
                // Ngược lại: ẩn textarea, hiển thị nội dung
                displayDiv.innerHTML = textarea.value;

                wrapper.classList.add('hidden');
                displayDiv.classList.remove('hidden');

            }

        }

        function addQuestion() {
            const form = document.getElementById('add-question-form');
            const selectedTypeId = form.querySelector('[name="question_type_id"]').value;
            const configSection = document.querySelector(`#question-type-${selectedTypeId}`);

            const inputs = configSection.querySelectorAll('input, select');
            const configData = {};
            inputs.forEach(input => { configData[input.name] = input.value;});
            console.log('Config Data:', configData);

            const input_type =  configData['input_type'] || null;
            const answer_label = configData['label'] || null;
            const num_answer = parseInt(configData['num_answer']) || 4; // Số đáp án mặc định là 4


            // them vị trí của câu hỏi vào content
            questionCounter++;
            const id = questionCounter;
            let html = `
                <div class="question-item border rounded p-3 my-3 flex justify-start items-start gap-2" id="question-${id}">
                    <!-- Nút toggle ẩn/hiện -->
                    <button type="button" onclick="toggleQuestionVisibility(this)" class="text-lg mt-1">
                        <i class="fa-regular fa-square-check"></i>
                    </button>

                    <!-- Nội dung câu hỏi -->
                    <div class="flex-grow">
                        <div class="flex justify-between items-center gap-4">
                            <p><strong>Câu hỏi ${id}:</strong></p>
                            <div class="flex items-center gap-4">
                                <!-- Loại câu hỏi -->
                                <div class="flex items-center gap-1">
                                    <i class="fa-solid fa-bars-staggered text-primary tooltip" data-theme="light" title="Loại câu hỏi"></i>
                                    <input type="text" class="form-control" disabled value="${selectingQuestionType}" />
                                </div>
                                <!-- Điểm -->
                                <div class="flex items-center gap-1">
                                    <i class="fa-regular fa-file-lines text-primary" title="Điểm"></i>
                                    <input type="number" name="total_score" min="0" max="100" value="1" class="form-control w-16" />
                                </div>
                            </div>
                        </div>
                        <!-- Nội dung bên trong câu hỏi -->
                        <div id="question-item-${id}" class="pl-4 mt-2">
                        </div>
                    </div>
                </div>`;

            const questionList = document.getElementById('question-list');
            questionList.insertAdjacentHTML('beforeend', html);

            /// Thêm cấu hình câu trả lời
            const configs = generateAnswerConfigs(input_type, answer_label, num_answer);
            render_answer_config(configs, 'question-item-'+id)

            // reset modal and close it
            form.reset(); // Reset form
            const modal = document.getElementById('add-question-modal');
            if (modal && typeof tailwind !== 'undefined' && tailwind.Modal) {
                const modalInstance = tailwind.Modal.getInstance(modal);
                modalInstance.hide(); // Ẩn modal nếu dùng tailwind modal JS
            } else {
                modal.classList.add('hidden'); // fallback thủ công
            }
        }

        function create_options(labelType, numAnswer, inputType) {
            let configs = [];

            switch (labelType) {
                case 'A-Z':
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: String.fromCharCode(65 + i), // A, B, C...
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
                    break;

                case '1-9':
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: (i + 1).toString(),
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
                    break;

                case 'T-F':
                    configs = [
                        { label: null, content: 'True', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'False', is_correct: false, input_type: 'radio' }
                    ];
                    break;

                case 'T-F-NG':
                    configs = [
                        { label: null, content: 'True', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'False', is_correct: false, input_type: 'radio' },
                        { label: null, content: 'Not Given', is_correct: false, input_type: 'radio' }
                    ];
                    break;

                default:
                    for (let i = 0; i < numAnswer; i++) {
                        configs.push({
                            label: (i + 1).toString(),
                            content: '',
                            is_correct: false,
                            input_type: inputType
                        });
                    }
            }

            return configs;
        }

        function render_answer_config(configList, answerId) {
            const container = document.getElementById(answerId);
            let html = '';
            configList.forEach((item, index) => {
                const input_type = item.input_type || 'text'; // Mặc định là text nếu không có input_type

                console.log("X01", input_type, item);
                switch (input_type) {
                    case 'text':
                    case 'textarea':
                    case 'select':
                        console.log("X")
                        html += `
                            <div class="answer-config-item border rounded p-3 my-2">
                                <div class="flex justify-start items-center rounded gap-4">
                                    <input type="checkbox" class="form-check-input" name="answer_is_correct[]" checked disabled/>
                                    <div class="flex-grow">
                                        <input type="text" class="form-control" name="answer_content[]" placeholder="`+ `${input_type === 'select'? "Nhập đáp án cách nhau dấu ','" : "Nhập nội dung đáp án..." }`+`" />
                                    </div>

                                    <button class="btn btn-secondary tooltip" type="button"
                                            data-theme="light" title="Thêm ghi chú cho đáp án"
                                            onclick="toggleAnswerNote(this)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>

                                <div class="answer-note hidden mt-2">
                                    <label class="form-label">Giải thích</label>
                                    <textarea name="answer_note[]" class="form-control" rows="2" placeholder="Giải thích cho đáp án..."></textarea>
                                </div>
                            </div>`;
                        break;
                    case 'radio':
                    case 'checkbox':
                        const labelHtml = item.label !== null
                            ? `<h4 class="font-semibold">Option ${item.label}</h4>`
                            : '';
                        html += `
                        <div class="answer-config-item border rounded p-3 my-2">
                            <div class="flex justify-start items-center rounded gap-4">
                                <input type="checkbox" class="form-check-input" name="answer_is_correct[]" />

                                ${labelHtml}

                                <div class="flex-grow">
                                    <input type="text" class="form-control" name="answer_content[]"
                                           value="${item.content ?? ''}"
                                           ${item.label === null ? 'readonly' : ''}
                                           placeholder="Nhập nội dung đáp án..." />
                                </div>

                                <button class="btn btn-secondary tooltip" type="button"
                                        data-theme="light" title="Thêm ghi chú cho đáp án"
                                        onclick="toggleAnswerNote(this)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>

                            <div class="answer-note hidden mt-2">
                                <label class="form-label">Giải thích</label>
                                <textarea name="answer_note[]" class="form-control" rows="2" placeholder="Giải thích cho đáp án..."></textarea>
                            </div>
                        </div>`;
                        break;
                    default:
                        break;
                }
            });
            container.innerHTML = html;
        }

        function toggleAnswerNote(button) {
            const answerItem = button.closest('.answer-config-item');
            const noteSection = answerItem.querySelector('.answer-note');
            if (noteSection) {
                noteSection.classList.toggle('hidden');
            }
        }

        function generateAnswerConfigs(inputType, labelType = 'A-Z', numAnswer = 4) {
            // Xử lý trường hợp inputType là text hoặc textarea: chỉ 1 đáp án
            if (inputType === 'text' || inputType === 'textarea' || inputType === 'select') {
                return [{
                    label: null,
                    content: '',
                    note: '',
                    is_correct: true,
                    input_type: inputType
                }];
            }
            // Nếu là radio/checkbox → cần tạo nhiều đáp án dựa vào labelType
            return create_options(labelType, numAnswer, inputType)
        }


        // TODO: edit nội dung của part
        function toggleEdit(btn) {
            const container = btn.closest('.part-content');
            const input = container.querySelector('.part-content-input');

            if (input.hasAttribute('readonly')) {
                input.removeAttribute('readonly');
                input.focus();
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-primary');
                btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i>';

                // Khi blur thì tự gọi lại toggleEdit để save
                input.addEventListener('blur', function handleBlur() {
                    // Xóa sự kiện blur sau 1 lần dùng để tránh lặp
                    input.removeEventListener('blur', handleBlur);
                    toggleEdit(btn);
                });


            } else {
                input.setAttribute('readonly', true);
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-secondary');
                btn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';

            }
        }


        function handleQuestionTypeChange(select) {
            selectingQuestionType = select.options[select.selectedIndex].text;
            document.querySelectorAll('.modal-question-configs').forEach(el => el.classList.add('hidden'));
            document.getElementById(`question-type-${select.value}`)?.classList.remove('hidden');

        }

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.querySelector('.form-select[onchange="handleQuestionTypeChange(this)"]');
            if (select) handleQuestionTypeChange(select);
        });

    </script>
@endsection
